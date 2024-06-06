import React, { useEffect, useState } from "react";
import { Link, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

function Prenotazione(a){
  const url = (id) => `/dettagliprenotazionecliente/${id}`;
  return (<div key={a.id}>
    <div>{a.orario}</div>
    <div>{a.ristoratore}</div>
    <div>{a.stato}</div>
    <div>{a.numero_inviti}</div>
    <div>{a.divisione_conto}</div>
    <a href={url(a.id)}>Dettagli</a>
  </div>);
}

export default function ClienteDashboard() {

    const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
    const [prenotazioni, setPrenotazioni] = useState(null);

    const fetchPrenotazioni = () => {
      axiosClient.get(`/dashboard_c/${profile}`).then(
        data => setPrenotazioni(data.data)
      );
    };

    useEffect(fetchPrenotazioni, []);

    return (
        <div className="container mt-5">
          {prenotazioni && prenotazioni.map(Prenotazione)}
        </div>
    );
}
