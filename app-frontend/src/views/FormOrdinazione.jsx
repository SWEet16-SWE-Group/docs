import { useEffect, useState } from "react";
import axiosClient from "../axios-client";
import {Link, useNavigate, useParams} from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";

function Input({id, nome, text, tipo, value, onChange}){
  if (tipo === "checkbox") {
    return (
      <div className="form-check mb-3">
        <input
          type="checkbox"
          className="form-check-input"
          id={id}
          name={nome}
          value={value}
          onChange={onChange}
        />
        <label className="form-check-label" htmlFor={id}>
          {text}
        </label>
      </div>
    );
  }
  return (
    <div className="mb-3">
      <label htmlFor={id} className="form-label">{text}</label>
      <input
        type={tipo}
        className="form-control"
        id={id}
        name={nome}
        onChange={onChange}
        defaultValue={value !== undefined ? value : 1}
        min="1"
      />
    </div>
  );
}

export default function FormOrdinazione() {
  const { profile, setNotification, setNotificationStatus } = useStateContext();
  const { prenotazione, pietanza } = useParams();
  const navigate = useNavigate();

  const [errorMessage, setErrorMessage] = useState('');
  const [aggiunte, setAggiunte] = useState([]);
  const [rimozioni, setRimozioni] = useState([]);
  const [invito, setInvito] = useState(null);
  const [dettagli, setDettagli] = useState(null);

  useEffect(() => {
    axiosClient.get(`/get-possibili-aggiunte/${pietanza}`).then(data => setAggiunte(data.data));
    axiosClient.get(`/get-possibili-rimozioni/${pietanza}`).then(data => setRimozioni(data.data));
    axiosClient.get(`/get-invito-by-prenotazione-cliente/${prenotazione}/${profile}`).then(data => setInvito(data.data[0].id));
    axiosClient.get(`/pietanza_dettagli/${pietanza}`).then(data => setDettagli(data.data));
  }, [pietanza, prenotazione, profile]);

  const handleSubmit = async (e) => {
    e.preventDefault();

    setErrorMessage('');

    try {
      const q = e.target.quantita.value;
      for (let i = 0; i < q; i += 1) {
        const formData = {
          invito: invito,
          pietanza: pietanza,
          aggiunte: Array.from(e.target.aggiunte).filter(a => a.checked).map(a => ({ ingrediente: a.value })),
          rimozioni: Array.from(e.target.rimozioni).filter(a => a.checked).map(a => ({ ingrediente: a.value })),
        };

        console.log(formData);
        const { data } = await axiosClient.post(`/crea-ordinazione`, formData);
        console.log(data);
        navigate(`/dettagliprenotazionecliente/${prenotazione}`);
      }

      setNotificationStatus('success');
      setNotification('Ordinazione creata con successo.');
    } catch (error) {
      console.log(error);
      setNotificationStatus('error');
      setNotification('Errore durante il salvataggio dell\'ordinazione.');
      setErrorMessage('Errore durante il salvataggio dell\'ordinazione.');
    }
  };

  return (
    <div className="container mt-5">
      <h1>Ordina</h1>
      <h2>{dettagli && dettagli.nome}</h2>
      <p>{dettagli && dettagli.ingredienti}</p>
      {dettagli && dettagli.allergeni && <p>Può contenere tracce di: <strong>{dettagli.allergeni}</strong></p>}
      {errorMessage && <div className="alert alert-danger" role="alert">{errorMessage}</div>}
      <form onSubmit={handleSubmit}>
        <Input id="quantita" nome="quantita" text="quantità" tipo="number" value={1} />
        <h4>Rimozioni</h4>
        {rimozioni.map(a => (
          <Input
            key={`rimozione_${a.id}`}
            id={`rimozione_${a.id}`}
            nome="rimozioni"
            value={a.id}
            text={a.nome}
            tipo="checkbox"
          />
        ))}
        <h4>Aggiunte</h4>
        {aggiunte.map(a => (
          <Input
            key={`aggiunta_${a.id}`}
            id={`aggiunta_${a.id}`}
            nome="aggiunte"
            value={a.id}
            text={a.nome}
            tipo="checkbox"
          />
        ))}
        <button type="submit" className="btn btn-primary">Ordina</button>
        &nbsp; &nbsp;
        <Link to={`/menu/${prenotazione}/${profile}`} className="btn btn-secondary ms-2">Annulla</Link>
      </form>
    </div>
  );
}