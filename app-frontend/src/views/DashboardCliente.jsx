import React, {useEffect, useRef, useState} from "react";
import {Link, useNavigate} from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

function Prenotazione(a){
  const url = (id) => `/dettagliprenotazionecliente/${id}`;
  return (<tr key={a.id}>
    <td>{a.orario}</td>
    <td>{a.nome}</td>
    <td>{a.numero_inviti}</td>
    <td>{a.stato}</td>
      {a.stato !== 'Rifiutata' &&
          <td><Link to={url(a.id)}>Dettagli</Link></td>
      }
  </tr>);
}

export default function ClienteDashboard() {

    const {profile, setNotification,setNotificationStatus} = useStateContext()
    const [prenotazioni, setPrenotazioni] = useState(null);
    const linkRef = useRef();
    const navigate = useNavigate();

    const fetchPrenotazioni = () => {
      axiosClient.get(`/dashboard_c/${profile}`).then(
        data => setPrenotazioni(data.data)
      );
    };

    useEffect(fetchPrenotazioni, []);

    const LinkInvito = (e) => {
        e.preventDefault();

        const prenotazione = linkRef.current.value;

        axiosClient.get(`/prenotazione_dettagli/${prenotazione}`).then(
            data => {
                if(data.data.id === undefined)
                {
                    setNotificationStatus('failure');
                    setNotification('Questo codice di invito non esiste!');
                }
                else
                    navigate('/invito/'+ prenotazione);
            }
        );
    }

    return (
        <>
            <form className="row row-cols-lg-auto g-3 align-items-center" onSubmit={LinkInvito}>
                <div className="col-auto">
                    <label htmlFor="link_invito">Hai un link di invito? Inseriscilo qui!</label>
                </div>
                <div className="col-auto">
                    <input type="number" ref={linkRef} className="form-control" id="link_invito" placeholder="Codice invito"/>
                </div>
                <div className="col-auto">
                    <button type="submit" className="btn btn-primary">Invia</button>
                </div>
            </form>
            <br />
            <table className="table">
                <thead>
                    <tr>
                        <th>Orario</th>
                        <th>Ristoratore</th>
                        <th>Numero Inviti</th>
                        <th>Stato</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    {prenotazioni && prenotazioni.map(Prenotazione)}
                </tbody>
            </table>
        </>
    );
}
