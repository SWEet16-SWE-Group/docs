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

export default function ClientePrenotazione() {

    const {user, profile, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
    const {id} = useParams();
    const [prenotazione, setPrenotazione] = useState(null);

    const fetchPrenotazioni = () => {
      axiosClient.get(`/prenotazione_c/${id}`).then(
        data => setPrenotazione(data.data)
      );
    };

    useEffect(fetchPrenotazioni, []);

    return (
        <div className="container mt-5">
          {prenotazione && Prenotazione(prenotazione)}
        </div>
    );
}
