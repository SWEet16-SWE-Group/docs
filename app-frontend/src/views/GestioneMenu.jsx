import React, { useEffect, useState } from "react";
import axiosClient from "../axios-client";
import { Link, useNavigate } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import { useParams } from 'react-router-dom';

export default function GestioneMenu() {
    const { ristoratoreId } = useParams();
    const navigate = useNavigate();
    const { setNotification, setNotificationStatus } = useStateContext();
    const [pietanze, setPietanze] = useState([]);

    useEffect(() => {
        const fetchPietanze = async () => {
            try {
                const response = await axiosClient.get(`/pietanze/${ristoratoreId}`);
                setPietanze(response.data);
            } catch (error) {
                console.error('Errore nel recupero delle pietanze', error);
            }
        };
        fetchPietanze();
    }, [ristoratoreId]);

    const onDeletePietanza = async (id) => {
        if (!window.confirm("Sei sicuro di voler eliminare questa pietanza?")) {
            return;
        }

        try {
            const response = await axiosClient.delete(`/pietanze/${id}`);
            setNotificationStatus('success');
            setNotification('Pietanza eliminato con successo.');
            setPietanze(pietanze.filter(pietanza => pietanza.id !== id));
        } catch (error) {
            setNotificationStatus('failure');
            setNotification('Errore durante l\'eliminazione della pietanza.');
            console.error('Errore nell\'eliminazione della pietanza', error);
        }
    };

    return (
        <div className="container mt-5">
            <div>
                <button className="btn btn-primary" onClick={() => navigate(`/creapietanza/${ristoratoreId}`)}>Aggiungi Pietanza</button>
                &nbsp;
                <Link to='/dashboardristoratore' className="btn btn-secondary">Annulla</Link>
            </div>
            <div>
                {pietanze.length === 0 ? (
                    <h2>Non è presente nessuna pietanza.</h2>
                ) : (
                    <table className="table mt-3">
                        <thead>
                            <tr>
                                <th>Nome Pietanza</th>
                                <th>Operazioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            {pietanze.map(pietanza => (
                                <tr key={pietanza.id}>
                                    <td>{pietanza.nome}</td>
                                    <td>
                                        <button className="btn btn-danger" onClick={() => onDeletePietanza(pietanza.id)}>Elimina</button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                )}
            </div>
        </div>
    );
}