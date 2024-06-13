import React, { useEffect, useState } from "react";
import {Link, useNavigate, useParams} from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

function Ordinazioni({data}){
  return (
    <>
      <thead>
        <tr><th colSpan="4"><h3>{data.nome}</h3></th></tr>
        <tr>
          <th>Pietanza</th>
          <th>Aggiunte</th>
          <th>Rimozioni</th>
          <th>Azioni</th>
        </tr>
      </thead>
      <tbody>
        {data.ordinazioni.map(ordinazione => (
          <tr key={ordinazione.id}>
              <td>{ordinazione.pietanza}</td>
              <td>{ordinazione.aggiunte}</td>
              <td>{ordinazione.rimozioni}</td>
              <td><button className="btn btn-block">Cancella</button></td>
          </tr>
        ))}
      </tbody>
    </>
  );
}

function Prenotazione(p){
  const url_p = (id) => `/divisionecontopagamentocliente/${id}`;
  const url_o = (r,p) => `/menu/${r}/${p}`;
  const a = p.prenotazione;

return (<div key={a.id}>
    <h1>{a.nome}</h1>
    <h2>Dettagli</h2>
    <div>Codice di invito: <Link>{a.id}</Link></div>
    <div>Stato: {a.stato}</div>
    <div>Orario: {a.orario}</div>
    <div><Link to={url_p(a.id)}>Esamina pagamento</Link></div>
    {a && a.stato === 'Accettata' &&
        <div><Link to={url_o(a.ristoratore, a.id)}>Ordina</Link></div>
    }
    <h2>Ordinazioni</h2>
    <table className="table">
        {p.ordinazioni && p.ordinazioni.map((data) => <Ordinazioni key={data.nome} data={data}/>)}
    </table>
</div>);
}

export default function ClientePrenotazione() {

    const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole,setNotificationStatus,setNotification} = useStateContext()
    const {id} = useParams();
    const [prenotazione, setPrenotazione] = useState(null);
    const navigate = useNavigate();

    const fetchPrenotazioni = () => {
      axiosClient.get(`/prenotazione_c/${id}`).then(
        data => { 
          setPrenotazione(data.data);
          console.log(data.data);
        }
      );
    };

    useEffect(fetchPrenotazioni, []);

    const deletePrenotazione = async () => {

        if (!window.confirm("Sei sicuro di voler annullare questa prenotazione?")) {
            return;
        }

        try {
            const response = await axiosClient.delete(`/prenotazione/${id}`);
            setNotificationStatus('success');
            setNotification('Prenotazione annullata con successo.');
            navigate('/dashboardcliente');

        } catch (error) {
            setNotificationStatus('error');
            setNotification('Errore durante l\'eliminazione della prenotazione.');
        }
    }

    return (
        <>
            <div className="container mt-5">
              {prenotazione && Prenotazione(prenotazione)}
            </div>
            <div>
                <Link to='/dashboardcliente' className='btn btn-primary'>Indietro</Link>
                &nbsp; &nbsp;
                <button onClick={deletePrenotazione} className='btn btn-primary'>Annulla prenotazione</button>
            </div>
        </>
    );
}
