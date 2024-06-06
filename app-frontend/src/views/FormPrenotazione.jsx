import { useState } from "react";
import axiosClient from "../axios-client";
import { useNavigate, useParams } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";

export default function FormPrenotazione() {
    const {profile, setNotification, setNotificationStatus} = useStateContext();
    const [data, setdata] = useState('');
    const [npersone, setnpersone] = useState('');
    const [errorMessage, setErrorMessage] = useState('');

    const { id } = useParams();
    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrorMessage('');

        try {
            const formData = {
                ristorante: id,
                data: data,
                npersone: npersone,
                cliente: profile,
            };
            await axiosClient.post('/ingredienti', formData);

            setNotificationStatus('success');
            setNotification('Prenotazione creata con successo.');
        } catch (error) {
            setNotificationStatus('error');
            setNotification('Errore durante il savaltaggio della prenotazione.');
            setErrorMessage('Errore durante il savaltaggio della prenotazione.');
        }
    };

    return (
        <div className="container mt-5">
            <h3>Prenota ristorante</h3>
            {errorMessage && <div className="alert alert-danger" role="alert">{errorMessage}</div>}
            &nbsp; &nbsp;
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="data" className="form-label">Data</label>
                    <input
                        type="date"
                        className="form-control"
                        id="data"
                        name="data"
                        onChange={(e) => setdata(e.target.value)}
                        required
                    />
                </div>
                <div className="mb-3">
                    <label htmlFor="npersone" className="form-label">Numero di persone</label>
                    <input
                        type="number"
                        className="form-control"
                        id="npersone"
                        name="npersone"
                        onChange={(e) => setnpersone(e.target.value)}
                        required
                    />
                </div>
                <button type="submit" className="btn btn-primary">Prenota</button>
                <button type="button" className="btn btn-secondary ms-2" >Annulla</button>
            </form>
        </div>
    );
}
