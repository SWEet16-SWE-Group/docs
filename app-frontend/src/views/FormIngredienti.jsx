import React, {useEffect, useState} from "react";
import axiosClient from "../axios-client";
import { useNavigate, useParams } from "react-router-dom";
import { useStateContext } from "../contexts/ContextProvider";
import { fetchAllergeni } from "../services/IntolleranzeService";

export default function FormIngrediente() {
    const { ristoratoreId } = useParams();
    const navigate = useNavigate();
    const { setNotification, setNotificationStatus } = useStateContext();
    const [nome, setNome] = useState('');
    const [errorMessage, setErrorMessage] = useState('');
    const [allergeni,setAllergeni] = useState([]);

    //selectedIds rappresenta gli allergeni selezionati
    const [selectedIds, setSelectedIds] = useState([]);

    const handleCheckboxChange = (event) => {
        const checkedId = event.target.value;
        if(event.target.checked){
            setSelectedIds([...selectedIds,checkedId])
        }else{
            setSelectedIds(selectedIds.filter(id=>id !== checkedId))
        }
    }

    async function getAllergeni() {
        try {
            const allergeni = await fetchAllergeni();
            setAllergeni(allergeni);
        } catch (error) {
            console.error('Error fetching allergeni:', error);
        }
    }

    useEffect( () => {
        getAllergeni();
    },[]);


    const handleSubmit = async (e) => {
        e.preventDefault();
        setErrorMessage('');

        try {
            const formData = {
                ristoratore: ristoratoreId,
                nome: nome,
                allergie: selectedIds
            };
            await axiosClient.post('/ingredienti', formData);

            setNotificationStatus('success');
            setNotification('Ingrediente aggiunto con successo.');
            navigate(`/gestioneIngredienti/${ristoratoreId}`);
        } catch (error) {
            setNotificationStatus('error');
            setNotification('Errore durante l\'aggiunta dell\'ingrediente.');
            setErrorMessage('Errore durante l\'aggiunta dell\'ingrediente. Per favore riprova.');
            console.error('Errore durante l\'aggiunta dell\'ingrediente', error);
        }
    };

    return (
        <div className="container mt-5">
            <h3>Aggiungi Ingrediente</h3>
            {errorMessage && <div className="alert alert-danger" role="alert">{errorMessage}</div>}
            &nbsp; &nbsp;
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="nome" className="form-label">Nome Ingrediente</label>
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
                {allergeni.length === 0 ? (<p>Loading...</p>) : (
                    <div>
                        <p>Seleziona uno o più allergeni contenuti in questo ingrediente: </p>
                        <br />
                        {allergeni.map((allergene) => {
                            return (
                                <div className="form-check flex">
                                    <input
                                        className="form-check-input"
                                        type="checkbox"
                                        value={allergene.id}
                                        id={allergene.id}
                                        onChange={(event) => {
                                            handleCheckboxChange(event)
                                        }
                                        }/>
                                    <label className="form-check-label" for={allergene.id}>
                                        {allergene.nome}
                                    </label>
                                </div>
                            );
                        })}
                    </div>)}
                <br />
                <div>
                    <button type="submit" className="btn btn-primary">Aggiungi</button>
                    <button type="button" className="btn btn-secondary ms-2" onClick={() => navigate(`/gestioneingredienti/${ristoratoreId}`)}>Annulla</button>
                </div>
            </form>
        </div>
    );
}