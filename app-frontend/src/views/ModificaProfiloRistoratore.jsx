import React, { useState, useEffect } from 'react';
import axiosClient from '../axios-client.js';

export default function ModificaProfiloRistoratore() {
    const [ristoratori, setRistoratori] = useState([]);
    const [selectedRistoratoreId, setSelectedRistoratoreId] = useState(null);
    const [formData, setFormData] = useState({
        user: localStorage.getItem('USER_ID'),
        nome: '',
        indirizzo: '',
        telefono: ''
    });
    const [errorMessage, setErrorMessage] = useState('');
    const [successMessage, setSuccessMessage] = useState('');
    const [loading, setLoading] = useState(true);

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
                        telefono: response.data.telefono
                    });
                    setLoading(false);
                } catch (error) {
                    setErrorMessage('Errore durante il recupero dei dati.');
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
        setSuccessMessage('');
        try {
            console.log(formData);
            const response = await axiosClient.put(`/modifica-ristoratore/${selectedRistoratoreId}`, formData);
            setSuccessMessage('Dati aggiornati con successo.');
            console.log(response.data);
        } catch (error) {
            setErrorMessage('Errore durante l\'aggiornamento dei dati.');
            console.error(error);
        }
    };

    const handleDelete = async () => {
        setErrorMessage('');
        setSuccessMessage('');
        try {
            const response = await axiosClient.delete(`/elimina-ristoratore/${selectedRistoratoreId}`);
            setSuccessMessage('Ristoratore eliminato con successo.');
            console.log(response.data);
            setFormData({
                nome: '',
                indirizzo: '',
                telefono: ''
            });
            setSelectedRistoratoreId(null);
            setLoading(true);
        } catch (error) {
            setErrorMessage('Errore durante l\'eliminazione del ristoratore.');
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
            {successMessage && <div className="alert alert-success" role="alert">{successMessage}</div>}
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
                                value={formData.telefono}
                                onChange={handleChange}
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
