import { useEffect, useState } from "react";
import axiosClient from "../axios-client";
import { Link, useNavigate } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import { useParams } from 'react-router-dom';

export default function GestioneIngredienti() {
    const { ristoratoreId } = useParams();
    const navigate = useNavigate();
    const { setNotification, setNotificationStatus } = useStateContext();
    const [ingredienti, setIngredienti] = useState([]);

    useEffect(() => {
        const fetchIngredienti = async () => {
            try {
                const response = await axiosClient.get(`/ingredienti/${ristoratoreId}`);
                setIngredienti(response.data);
            } catch (error) {
                console.error('Errore nel recupero degli ingredienti', error);
            }
        };
        fetchIngredienti();
    }, [ristoratoreId]);

    const onDeleteIngrediente = async (id) => {
        if (!window.confirm("Sei sicuro di voler eliminare questo ingrediente?")) {
            return;
        }

        try {
            const response = await axiosClient.delete(`/ingredienti/${id}`);
            setNotificationStatus('success');
            setNotification('Ingrediente eliminato con successo.');
            setIngredienti(ingredienti.filter(ingrediente => ingrediente.id !== id));
        } catch (error) {
            setNotificationStatus('error');
            setNotification('Errore durante l\'eliminazione dell\'ingrediente.');
            console.error('Errore nell\'eliminazione dell\'ingrediente', error);
        }
    };

    return (
        <div className="container mt-5">
            <div>
                <button className="btn btn-primary" onClick={() => navigate(`/creaingrediente/${ristoratoreId}`)}>Aggiungi Ingrediente</button>
            </div>
            <div>
                {ingredienti.length === 0 ? (
                    <h2>Non è presente nessun ingrediente.</h2>
                ) : (
                    <table className="table mt-3">
                        <thead>
                            <tr>
                                <th>Nome Ingrediente</th>
                                <th>Operazioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            {ingredienti.map(ingrediente => (
                                <tr key={ingrediente.id}>
                                    <td>{ingrediente.nome}</td>
                                    <td>
                                        <button className="btn btn-danger" onClick={() => onDeleteIngrediente(ingrediente.id)}>Elimina</button>
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