import React, { useEffect, useState } from "react";
import { Link, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

export default function RistoratorePrenotazione() {
  const { id } = useParams();
  const [prenotazioneData, setPrenotazioneData] = useState(null);
  const [ingredientiData, setIngredientiData] = useState(null);
  const { setNotificationStatus, setNotification } = useStateContext();

  useEffect(() => {
    const fetchPrenotazione = async () => {
      try {
        const response = await axiosClient.get(`/prenotazione_c/${id}`);
        console.log('Prenotazione data fetched:', response.data);
        setPrenotazioneData(response.data);
      } catch (error) {
        console.error('Errore nel recupero della prenotazione:', error);
      }
    };

    const fetchIngredienti = async () => {
      try {
        const response = await axiosClient.get(`prenotazione_i/${id}`);
        console.log('Ingredienti data fetched:', response.data);
        setIngredientiData(response.data);
      } catch (error) {
        console.error('Errore nel recupero degli ingredienti:', error);
      }
    };

    fetchPrenotazione();
    fetchIngredienti();
  }, [id]);

  const handleAccept = async () => {
    try {
      await axiosClient.put(`/update-prenotazioni/${id}`, { stato: 'Accettata' });
      setPrenotazioneData((prevState) => ({
        ...prevState,
        prenotazione: {
          ...prevState.prenotazione,
          stato: 'Accettata',
        },
      }));
      setNotificationStatus('success');
      setNotification('Prenotazione accettata con successo.');
    } catch (error) {
      setNotificationStatus('failure');
      setNotification('Errore durante l\'accettazione della prenotazione.');
      console.error('Errore nell\'accettazione della prenotazione:', error);
    }
  };

  const handleRefuse = async () => {
    try {
      await axiosClient.put(`/update-prenotazioni/${id}`, { stato: 'Rifiutata' });
      setPrenotazioneData((prevState) => ({
        ...prevState,
        prenotazione: {
          ...prevState.prenotazione,
          stato: 'Rifiutata',
        },
      }));
      setNotificationStatus('success');
      setNotification('Prenotazione rifiutata con successo.');
    } catch (error) {
      setNotificationStatus('failure');
      setNotification('Errore durante il rifiuto della prenotazione.');
      console.error('Errore nel rifiuto della prenotazione:', error);
    }
  };

  if (!prenotazioneData) {
    return <div>Caricamento...</div>;
  }

  const { prenotazione, ordinazioni } = prenotazioneData;
  const url_p = (id) => `/divisionecontopagamentoristoratore/${id}`;

  return (
    <div className="container mt-5">
      <div key={prenotazione.id}>
        <h1>{prenotazione.nome}</h1>
        <h2>Dettagli</h2>
        <div>Link di invito: <Link to={`/invito/${prenotazione.id}`}>localhost:3000/invito/{prenotazione.id}</Link></div>
        <div>Stato: {prenotazione.stato}</div>
        <div>Orario: {prenotazione.orario}</div>
        <div><Link to={url_p(prenotazione.id)}>Esamina pagamento</Link></div>
        {prenotazione.stato === "In attesa" && (
          <div className="mt-3">
            <button className="btn btn-success me-2" onClick={handleAccept}>
              Accetta
            </button>
            <button className="btn btn-danger" onClick={handleRefuse}>
              Rifiuta
            </button>
          </div>
        )}
        <hr className="my-4" />
        <h2>Ingredienti</h2>
        <table className="table table-bordered">
          <thead>
            <tr>
              <th>Ingrediente</th>
              <th>Quantità</th>
            </tr>
          </thead>
          <tbody>
            {ingredientiData && ingredientiData.map((ingrediente) => (
              <tr key={ingrediente.ingrediente}>
                <td>{ingrediente.ingrediente}</td>
                <td>{ingrediente.quantita}</td>
              </tr>
            ))}
          </tbody>
        </table>
        <hr className="my-4" />
        <h2>Ordinazioni</h2>
        {ordinazioni && ordinazioni.map((data) => (
          <div key={data.nome}>
            <table className="table table-bordered">
              <thead>
                <tr>
                  <th colSpan="5">
                    <h3>{data.nome}</h3>
                  </th>
                </tr>
                <tr>
                  <th>Pietanza</th>
                  <th>Ingredienti</th>
                  <th>Aggiunte</th>
                  <th>Rimozioni</th>
                  <th>Azioni</th>
                </tr>
              </thead>
              <tbody>
                {data.ordinazioni.map((ordinazione) => (
                  <tr key={ordinazione.id}>
                    <td>{ordinazione.pietanza}</td>
                    <td>{ordinazione.ingredienti}</td>
                    <td>{ordinazione.aggiunte}</td>
                    <td>{ordinazione.rimozioni}</td>
                    <td><button className="btn btn-danger">Cancella</button></td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        ))}
      </div>
      <div className="mt-3">
        <Link to='/dashboardristoratore' className='btn btn-primary'>Annulla</Link>
      </div>
    </div>
  );
}
