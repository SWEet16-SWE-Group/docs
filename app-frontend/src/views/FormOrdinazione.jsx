import { useEffect, useState } from "react";
import axiosClient from "../axios-client";
import { useNavigate, useParams } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";

function Input({id, nome, tipo, onChange}){
  return (
    <div className="mb-3">
      <label htmlFor={id} className="form-label">{nome}</label>
      <input
          type={tipo}
          className="form-control"
          id={id}
          name={nome}
          onChange={onChange}
          required
          min="1"
      />
    </div>
  );
}

export default function FormOrdinazione() {
    const {profile, setNotification, setNotificationStatus} = useStateContext();
    const {prenotazione, pietanza} = useParams();

    const [errorMessage, setErrorMessage] = useState('');

    const [aggiunte, setAggiunte] = useState(null);
    const [rimozioni, setRimozioni] = useState(null);

    useEffect(() => {
      axiosClient.get(`/get-possibili-aggiunte/${pietanza}`).then(data => setAggiunte(data.data))
      axiosClient.get(`/get-possibili-rimozioni/${pietanza}`).then(data => setRimozioni(data.data))
    }, []);

    console.log(aggiunte);
    console.log(rimozioni);

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrorMessage('');

        try {
            const formData = {
            };

            const {data: prenotazione} = await axiosClient.post(`/crea-prenotazione`, formData);
            console.log(prenotazione);

            const {data: invito} = await axiosClient.post(`/crea-invito`, {cliente:profile, prenotazione:prenotazione.id});
            console.log(invito);

            setNotificationStatus('success');
            setNotification('Prenotazione creata con successo.');
        } catch (error) {
            setNotificationStatus('error');
            setNotification('Errore durante il savaltaggio della prenotazione.');
            setErrorMessage('Errore durante il savaltaggio della prenotazione.');
        }
    };

    function rurl(id) {
      return `rimozione_${id}`;
    }

    function aurl(id) {
      return `aggiunta_${id}`;
    }

    return (
        <div className="container mt-5">
            <h3>Ordina</h3>
            <p> &lt;&lt; Dettagli della pietanza &gt;&gt; </p>
            {errorMessage && <div className="alert alert-danger" role="alert">{errorMessage}</div>}
            &nbsp; &nbsp;
            <form onSubmit={handleSubmit}>
                <Input id={"quantità"} nome={"quantità"} tipo={"number"} />
                <h4>Rimozioni</h4>
                {rimozioni && rimozioni.map(a => <Input id={rurl(a.id)} nome={a.nome} tipo={'checkbox'} />)}
                <h4>Aggiunte</h4>
                {aggiunte && aggiunte.map(a => <Input id={aurl(a.id)} nome={a.nome} tipo={'checkbox'} />)}
                <button type="submit" className="btn btn-primary">Ordina</button>
                <button type="button" className="btn btn-secondary ms-2" >Annulla</button>
            </form>
        </div>
    );
}
