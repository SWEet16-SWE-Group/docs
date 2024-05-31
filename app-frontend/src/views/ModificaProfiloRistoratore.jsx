import React, { useState, useEffect } from 'react';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';

export default function ModificaProfiloRistoratore() {
    const { setNotificationStatus, setNotification } = useStateContext();
    const [ristoratori, setRistoratori] = useState([]);
    const [selectedRistoratoreId, setSelectedRistoratoreId] = useState(null);
    const [formData, setFormData] = useState({
        user: localStorage.getItem('USER_ID'),
        nome: '',
        indirizzo: '',
        telefono: '',
        capienza: '',
        orario: ''
    });
    const [errorMessage, setErrorMessage] = useState('');
    const [loading, setLoading] = useState(true);

    // Togliere questo quando si implementa SceltaProfilo
    useEffect(() => {
        const fetchRistoratori = async () => {
            try {
                const userId = localStorage.getItem('USER_ID');
                const response = await axiosClient.get(`/ristoratori/${userId}`);
                setRistoratori(response.data);
                if (response.data.length > 0) {
                    setSelectedRistoratoreId(response.data[0].id);
                }
            } catch (error) {
                setErrorMessage('Errore durante il recupero dei ristoratori.');
                setNotificationStatus('error');
                setNotification('Errore durante il recupero dei ristoratori.');
                console.error(error);
                setLoading(false);
            }
        };
        fetchRistoratori();
    }, []);

    useEffect(() => {
        if (selectedRistoratoreId) {
            const fetchData = async () => {
                try {
                    const response = await axiosClient.get(`/get-ristoratore/${selectedRistoratoreId}`);
                    setFormData({
                        user: localStorage.getItem('USER_ID'),
                        nome: response.data.nome,
                        indirizzo: response.data.indirizzo,
                        telefono: response.data.telefono,
                        capienza: response.data.capienza,
                        orario: response.data.orario
                    });
                    setLoading(false);
                } catch (error) {
                    setErrorMessage('Errore durante il recupero dei dati.');
                    setNotificationStatus('error');
                    setNotification('Errore durante il recupero dei dati.');
                    console.error(error);
                    setLoading(false);
                }
            };

            fetchData();
        }
    }, [selectedRistoratoreId]);

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrorMessage('');
        try {
            const response = await axiosClient.put(`/modifica-ristoratore/${selectedRistoratoreId}`, formData);
            setNotificationStatus('success');
            setNotification('Dati aggiornati con successo.');
        } catch (error) {
            setErrorMessage('Errore durante l\'aggiornamento dei dati.');
            setNotificationStatus('error');
            setNotification('Errore durante l\'aggiornamento dei dati.');
            console.error(error);
        }
    };

    const handleDelete = async () => {
        setErrorMessage('');
        try {
            const response = await axiosClient.delete(`/elimina-ristoratore/${selectedRistoratoreId}`);
            setNotificationStatus('success');
            setNotification('Ristoratore eliminato con successo.');
            setFormData({
                user: localStorage.getItem('USER_ID'),
                nome: '',
                indirizzo: '',
                telefono: '',
                capienza: '',
                orario: ''
            });
            setSelectedRistoratoreId(null);
            setLoading(true);
        } catch (error) {
            setErrorMessage('Errore durante l\'eliminazione del ristoratore.');
            setNotificationStatus('error');
            setNotification('Errore durante l\'eliminazione del ristoratore.');
            console.error(error);
        }
    };

    const handleSelectChange = (e) => {
        setSelectedRistoratoreId(e.target.value);
        setLoading(true);
    };

    return (
        <div className="container mt-5">
            <h3>Modifica account ristoratore</h3>
            {errorMessage && <div className="alert alert-danger" role="alert">{errorMessage}</div>}
            {loading ? (
                <div className="d-flex justify-content-center">
                    <div className="spinner-border" role="status">
                        <span className="sr-only"></span>
                    </div>
                </div>
            ) : (
                <>
                    <div className="mb-3">
                        <label htmlFor="ristoratore-select">Seleziona Ristoratore</label>
                        <select
                            className="form-control"
                            id="ristoratore-select"
                            value={selectedRistoratoreId}
                            onChange={handleSelectChange}
                        >
                            {ristoratori.map((ristoratore) => (
                                <option key={ristoratore.id} value={ristoratore.id}>
                                    {ristoratore.nome}
                                </option>
                            ))}
                        </select>
                    </div>
                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="nome">Nome</label>
                            <input
                                type="text"
                                className="form-control"
                                id="nome"
                                name="nome"
                                value={formData.nome}
                                onChange={handleChange}
                                required
                            />
                        </div>
                        <div className="mb-3">
                            <label htmlFor="indirizzo">Indirizzo</label>
                            <input
                                type="text"
                                className="form-control"
                                id="indirizzo"
                                name="indirizzo"
                                value={formData.indirizzo}
                                onChange={handleChange}
                                required
                            />
                        </div>
                        <div className="mb-3">
                            <label htmlFor="telefono">Telefono</label>
                            <input
                                type="text"
                                className="form-control"
                                id="telefono"
                                name="telefono"
                                maxLength="10"
                                value={formData.telefono}
                                onChange={handleChange}
                                required
                            />
                        </div>
                        <div className="mb-3">
                            <label htmlFor="capienza">Capienza</label>
                            <input
                                type="number"
                                className="form-control"
                                id="capienza"
                                name="capienza"
                                min="1"
                                value={formData.capienza}
                                onChange={handleChange}
                                required
                            />
                        </div>
                        <div className="mb-3">
                            <label htmlFor="orario">Orario</label>
                            <input
                                type="text"
                                className="form-control"
                                id="orario"
                                name="orario"
                                value={formData.orario}
                                onChange={handleChange}
                                pattern="\d{2}:\d{2} - \d{2}:\d{2}"
                                placeholder="19:30 - 20:30"
                                title="Inserisci l'orario nel formato 19:30 - 20:30"
                                required
                            />
                        </div>
                        <div>
                            <button type="submit" className="btn btn-primary me-2">Modifica</button>
                            <button type="button" className="btn btn-danger" onClick={handleDelete}>Elimina</button>
                        </div>
                    </form>
                </>
            )}
        </div>
    );
}
