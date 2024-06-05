import { useState } from "react";
import axiosClient from "../axios-client";
import { useNavigate, useParams } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";

export default function FormPietanza() {
    const { ristoratoreId } = useParams();
    const navigate = useNavigate();
    const { setNotification, setNotificationStatus } = useStateContext();
    const [nome, setNome] = useState('');
    const [errorMessage, setErrorMessage] = useState('');

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrorMessage('');

        try {
            const formData = {
                ristoratore: ristoratoreId,
                nome: nome
            };
            await axiosClient.post('/pietanze', formData);

            setNotificationStatus('success');
            setNotification('Pietanza aggiunta con successo.');
            navigate(`/gestionemenu/${ristoratoreId}`);
        } catch (error) {
            setNotificationStatus('error');
            setNotification('Errore durante l\'aggiunta della pietanza.');
            setErrorMessage('Errore durante l\'aggiunta della pietanza. Per favore riprova.');
            console.error('Errore durante l\'aggiunta della pietanza', error);
        }
    };

    return (
        <div className="container mt-5">
            <h3>Aggiungi Pietanza</h3>
            {errorMessage && <div className="alert alert-danger" role="alert">{errorMessage}</div>}
            &nbsp; &nbsp;
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="nome" className="form-label">Nome Pietanza</label>
                    <input
                        type="text"
                        className="form-control"
                        id="nome"
                        name="nome"
                        value={nome}
                        onChange={(e) => setNome(e.target.value)}
                        required
                    />
                </div>
                <button type="submit" className="btn btn-primary">Aggiungi</button>
                <button type="button" className="btn btn-secondary ms-2" onClick={() => navigate(`/gestionemenu/${ristoratoreId}`)}>Annulla</button>
            </form>
        </div>
    );
}