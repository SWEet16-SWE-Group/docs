import React, { useEffect, useState } from "react";
import { Link, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

export default function RistoratoreDashboard() {
    const { profile, setNotification, setNotificationStatus } = useStateContext();
    const [ristoratoreInfo, setRistoratoreInfo] = useState(null);
    const [prenotazioni, setPrenotazioni] = useState([]);

    const ristoratore= profile;

    useEffect(() => {
        if (ristoratore) {
            fetchRistoratoreInfo(ristoratore);
            fetchPrenotazioni(ristoratore);
        }
    }, [ristoratore]);

    const fetchRistoratoreInfo = async (ristoratore) => {
        try {
            const response = await axiosClient.get(`/get-ristoratore/${ristoratore}`);
            setRistoratoreInfo(response.data);
        } catch (error) {
            setNotificationStatus('failure');
            setNotification('Errore durante il recupero delle informazioni del ristoratore.');
            console.error(error);
        }
    };

    const fetchPrenotazioni = async (ristoratore) => {
        try {
            const response = await axiosClient.get(`/prenotazioni/${ristoratore}`);
            setPrenotazioni(response.data);
            console.log(response.data);
        } catch (error) {
            setNotification('failure');
            setNotification('Errore durante il recupero delle prenotazioni');
            console.error(error);
        }
    };

    const updatePrenotazioneStatus = async (prenotazioneId, status) => {
        try {
            const response = await axiosClient.put(`/update-prenotazioni/${prenotazioneId}`, { stato: status });
            setPrenotazioni((prevPrenotazioni) =>
                prevPrenotazioni.map((prenotazione) =>
                    prenotazione.id === prenotazioneId
                        ? { ...prenotazione, stato: status }
                        : prenotazione
                )
            );
            setNotificationStatus('success');
            setNotification(`Prenotazione ${status.toLowerCase()} con successo.`);
        } catch (error) {
            setNotificationStatus('error');
            setNotification('Errore durante l\'aggiornamento della prenotazione.');
            console.error(error);
        }
    };

    const formatOrario = (orario) => {
        const date = new Date(orario);
        return date.toLocaleDateString('it-IT') + ' ' + date.toLocaleTimeString('it-IT', { hour: '2-digit', minute: '2-digit' });
    };

    return (
        <div className="container mt-5">
            <h1>Dashboard Ristoratore</h1>
            {ristoratoreInfo ? (
                <div>
                    <h3>Informazioni:</h3>
                    <p>Nome: {ristoratoreInfo.nome}</p>
                    <p>Tipo cucina: {ristoratoreInfo.cucina}</p>
                    <p>Indirizzo: {ristoratoreInfo.indirizzo}</p>
                    <p>Telefono: {ristoratoreInfo.telefono}</p>
                    <p>Capienza: {ristoratoreInfo.capienza}</p>
                    <p>Orario: {ristoratoreInfo.orario}</p>
                    <Link to={`/modificaprofiloristoratore/${ristoratore}`}>Modifica Informazioni</Link>
                    <hr className="my-4"></hr>
                    <h2>Prenotazioni</h2>
                    {prenotazioni.length > 0 ? (
                        <table className="table">
                            <thead>
                                <tr>
                                    <th>Orario</th>
                                    <th>Numero Inviti</th>
                                    <th>Stato</th>
                                    <th>Azioni</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                {prenotazioni.map((prenotazione) => (
                                    <tr key={prenotazione.id}>
                                        <td>{formatOrario(prenotazione.orario)}</td>
                                        <td>{prenotazione.numero_inviti}</td>
                                        <td>{prenotazione.stato}</td>
                                        <td>
                                            {prenotazione.stato === 'In attesa' && (
                                                <>
                                                    <button onClick={() => updatePrenotazioneStatus(prenotazione.id, 'Accettata')} className="btn btn-success">Accetta</button>
                                                    &nbsp;
                                                    <button onClick={() => updatePrenotazioneStatus(prenotazione.id, 'Rifiutata')} className="btn btn-danger">Rifiuta</button>
                                                </>
                                            )}
                                            {prenotazione.stato === 'Accettata' && (
                                                <Link to={`/divisionecontopagamentoristoratore/${prenotazione.id}`} className="btn">Pagamenti</Link>
                                            )}
                                        </td>
                                        <td><Link to={`/dettagliprenotazioneristoratore/${prenotazione.id}`}>Dettagli</Link></td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    ) : (
                        <p>Nessuna prenotazione disponibile.</p>
                    )}
                    <hr className="my-4"></hr>
                    <h4>Menu</h4>
                    <Link to={`/gestionemenu/${ristoratore}`}>Gestisci Menu</Link>
                    <h4>Ingredienti</h4>
                    <Link to={`/gestioneingredienti/${ristoratore}`}>Gestisci Ingredienti</Link>
                </div>
            ) : (
                <p>Caricamento informazioni...</p>
            )}
        </div>
    );
}
