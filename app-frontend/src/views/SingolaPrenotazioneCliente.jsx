import React, { useEffect, useState } from "react";
import { Link, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

function Ordinazioni({data}){
  return (
  <div>
    <h3>{data.nome}</h3>
    <table>
      <thead>
        <tr>
          <th>Pietanza</th>
          <th>Aggiunte</th>
          <th>Rimozioni</th>
        </tr>
      </thead>
      <tbody>
        {data.ordinazioni.map(ordinazione => (
          <tr key={ordinazione.id}>
              <td>{ordinazione.pietanza}</td>
              <td>{ordinazione.aggiunte}</td>
              <td>{ordinazione.rimozioni}</td>
          </tr>
        ))}
      </tbody>
    </table>
  </div>
  );
}

function Prenotazione(a){
  const url_p = (id) => `/divisionecontopagamento/${id}`;
  const url_o = (id) => `/menu/${id}`;
  return (<div key={a.id}>
    <h1>{a.nome}</h1>
    <h2>Dettagli</h2>
    <div>Stato: {a.stato}</div>
    <div>Orario: {a.orario}</div>
    <div><a href={url_p(a.id)}>Esamina pagamento</a></div>
    <h2>Ordinazioni</h2>
    <div><a href={url_o(a.ristoratore)}>Ordina</a></div>
  </div>);
    //{a.ordinazioni.map(Ordinazioni)}
}

export default function ClientePrenotazione() {

    const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
    const {id} = useParams();
    const [prenotazione, setPrenotazione] = useState(null);

    const fetchPrenotazioni = () => {
      axiosClient.get(`/prenotazione_c/${id}`).then(
        data => { 
          setPrenotazione(data.data);
          console.log(data.data);
        }
      );
    };

    useEffect(fetchPrenotazioni, []);

    return (
        <div className="container mt-5">
          {prenotazione && Prenotazione(prenotazione[0])}
        </div>
    );
}
