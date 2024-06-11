import React, { useState } from 'react';
import axiosClient from '../axios-client.js';
import { useStateContext } from '../contexts/ContextProvider.jsx';
import { Link, useNavigate } from "react-router-dom";

export default function CreazioneProfiloRistoratore() {
    const { setNotificationStatus, setNotification } = useStateContext();
    const navigate = useNavigate();

    const [formData, setFormData] = useState({
        user: localStorage.getItem('USER_ID'),
        nome: '',
        cucina: '',
        indirizzo: '',
        telefono: '',
        capienza: '',
        orario: ''
    });
    const [errors, setErrors] = useState(null);

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        setErrors(null);

        axiosClient.post('/crea-ristoratore', formData)
            .then(({data}) => {
                navigate('/selezioneprofilo');
                setNotificationStatus(data.status);
                setNotification(data.notification);
            })
            .catch(error => {
                setErrors(error.response.data.errors);
            });
    };

    const cuisineOptions = ['Italiana','Cinese','Giapponese', 'Messicana', 'Indiana', 'Meditteranea'];

    return (
        <div className="container mt-5">
            <h3>Crea account ristoratore</h3>
            {errors && <div className="alert">
                {Object.keys(errors).map(key => (
                    <p key={key}>{errors[key][0]}</p>
                ))}
            </div>}
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
                    <label htmlFor="cucina">Tipo di cucina</label>
                    <select
                        className="form-control"
                        id="cucina"
                        name="cucina"
                        value={formData.cucina}
                        onChange={handleChange}
                        required
                    >
                        <option value="">Seleziona il tipo di cucina</option>
                        {cuisineOptions.map((cuisine, index) => (
                            <option key={index} value={cuisine}>{cuisine}</option>
                        ))}
                    </select>
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
                        maxLength="10"
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
                    <label htmlFor="orario">Orario apertura - chiusura</label>
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
                    <button type="submit" className="btn btn-primary me-2">Conferma</button>
                    &nbsp; &nbsp;
                    <Link to='/selezioneprofilo' className="btn btn-secondary">Annulla</Link>
                </div>
            </form>
        </div>
    );
}
