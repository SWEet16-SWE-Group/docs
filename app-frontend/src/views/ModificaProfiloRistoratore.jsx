import React, { useState, useEffect } from 'react';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';
import { useParams } from 'react-router-dom';

export default function ModificaProfiloRistoratore() {
    const { id } = useParams();

    debugger;
    const { setNotificationStatus, setNotification } = useStateContext();
    const [formData, setFormData] = useState({
        user: localStorage.getItem('USER_ID'),
        nome: '',
        indirizzo: '',
        telefono: '',
        capienza: '',
        orario: ''
    });
    const [errorMessage, setErrorMessage] = useState('');

    useEffect(() => {
        if (id) {
            const fetchData = async () => {
                try {
                    const response = await axiosClient.get(`/get-ristoratore/${id}`);
                    setFormData({
                        user: localStorage.getItem('USER_ID'),
                        nome: response.data.nome,
                        indirizzo: response.data.indirizzo,
                        telefono: response.data.telefono,
                        capienza: response.data.capienza,
                        orario: response.data.orario
                    });
                } catch (error) {
                    setErrorMessage('Errore durante il recupero dei dati.');
                    console.error(error);
                }
            };
            fetchData();
        }
    }, [id]);

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
            const response = await axiosClient.put(`/modifica-ristoratore/${id}`, formData);
            setNotificationStatus('success');
            setNotification('Dati aggiornati con successo.');
        } catch (error) {
            setErrorMessage('Errore durante l\'aggiornamento dei dati.');
            console.error(error);
        }
    };

    const handleDelete = async () => {
        setErrorMessage('');
        try {
            const response = await axiosClient.delete(`/elimina-ristoratore/${id}`);
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
        } catch (error) {
            setErrorMessage('Errore durante l\'eliminazione del ristoratore.');
            console.error(error);
        }
    };

    return (
        <div className="container mt-5">
            <h3>Modifica account ristoratore</h3>
            {errorMessage && <div className="alert alert-danger" role="alert">{errorMessage}</div>}
            <>
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
        </div>
    );
}