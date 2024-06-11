import React, { useEffect, useState } from "react";
import { Link, useParams } from 'react-router-dom';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

function Ordinazioni({ data }) {
    return (
        <div key={data.nome}>
            <table className="table table-bordered">
                <thead>
                    <tr><th colSpan="5"><h3>{data.nome}</h3></th></tr>
                    <tr>
                        <th>Pietanza</th>
                        <th>Ingredienti</th>
                        <th>Aggiunte</th>
                        <th>Rimozioni</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    {data.ordinazioni.map(ordinazione => (
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
    );
}

function Prenotazione({ prenotazione, ordinazioni, handleAccept, handleRefuse }) {
    const a = prenotazione;
    const url_p = (id) => `/divisionecontopagamentoristoratore/${id}`;
    return (
        <div key={a.id}>
            <h1>{a.nome}</h1>
            <h2>Dettagli</h2>
            <div>Link di invito: <Link to={`/invito/${a.id}`}>localhost:3001/invito/{a.id}</Link></div>
            <div>Stato: {a.stato}</div>
            <div>Orario: {a.orario}</div>
            <div><Link to={url_p(a.id)}>Esamina pagamento</Link></div>
            {a.stato === "In attesa" && (
                <div className="mt-3">
                    <button className="btn btn-success me-2" onClick={handleAccept}>Accetta</button>
                    <button className="btn btn-danger" onClick={handleRefuse}>Rifiuta</button>
                </div>
            )}
            <hr className="my-4"></hr>
            <h2>Ingredienti</h2>
            <table>
              <thead>
                <tr>
                  <th>Ingrediente</th>
                  <th>Quantità</th>
                </tr>
              </thead>
              <tbody>
                <tr><td>Pasta</td><td>2</td></tr>
                <tr><td>Pomodoro</td><td>2</td></tr>
                <tr><td>Mozzarella</td><td>2</td></tr>
                <tr><td>Patatine</td><td>1</td></tr>
                <tr><td>Funghi</td><td>1</td></tr>
              </tbody>
            </table>
            <hr className="my-4"></hr>
            <h2>Ordinazioni</h2>
            {ordinazioni.map((data) => <Ordinazioni key={data.nome} data={data} />)}
        </div>
    );
}

export default function RistoratorePrenotazione() {
    const { id } = useParams();
    const [prenotazioneData, setPrenotazioneData] = useState(null);
    const { setNotificationStatus, setNotification } = useStateContext();

    const fetchPrenotazione = () => {
        axiosClient.get(`/prenotazione_r/${id}`).then(
            response => {
                setPrenotazioneData(response.data);
            }
        ).catch(error => {
            console.error('Errore nel recupero della prenotazione:', error);
        });
    };

    const handleAccept = () => {
        axiosClient.put(`/update-prenotazioni/${id}`, { stato: 'Accettata' }).then(
            response => {
                setPrenotazioneData(prevState => ({
                    ...prevState,
                    prenotazione: {
                        ...prevState.prenotazione,
                        stato: 'Accettata'
                    }
                }));
                setNotificationStatus('success');
                setNotification('Prenotazione accettata con successo.');
            }
        ).catch(error => {
            setNotificationStatus('error');
            setNotification('Errore durante l\'accettazione della prenotazione.');
            console.error('Errore nell\'accettazione della prenotazione:', error);
        });
    };

    const handleRefuse = () => {
        axiosClient.put(`/update-prenotazioni/${id}`, { stato: 'Rifiutata' }).then(
            response => {
                setPrenotazioneData(prevState => ({
                    ...prevState,
                    prenotazione: {
                        ...prevState.prenotazione,
                        stato: 'Rifiutata'
                    }
                }));
                setNotificationStatus('success');
                setNotification('Prenotazione rifiutata con successo.');
            }
        ).catch(error => {
            setNotificationStatus('error');
            setNotification('Errore durante il rifiuto della prenotazione.');
            console.error('Errore nel rifiuto della prenotazione:', error);
        });
    };

    useEffect(() => {
        fetchPrenotazione();
    }, [id]);

    return (
        <div className="container mt-5">
            {prenotazioneData ? (
                <Prenotazione 
                    prenotazione={prenotazioneData.prenotazione} 
                    ordinazioni={prenotazioneData.ordinazioni} 
                    handleAccept={handleAccept} 
                    handleRefuse={handleRefuse} 
                />
            ) : (
                <div>Caricamento...</div>
            )}
            <div className="mt-3">
                <Link to='/dashboardristoratore' className='btn btn-primary'>Annulla</Link>
            </div>
        </div>
    );
}
