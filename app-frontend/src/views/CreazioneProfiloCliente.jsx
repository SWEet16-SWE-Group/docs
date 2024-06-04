import React, { useEffect} from "react";
import {useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axios from "axios";
import { fetchAllergeni } from "../services/IntolleranzeService";
import ContextProvider, {useStateContext} from "../contexts/ContextProvider";
import axiosClient from "../axios-client.js";

export default function CreazioneProfiloCliente() {

    const {role, setNotification, setNotificationStatus } = useStateContext();

    const [formData, setFormData] = useState({
        account_id: localStorage.getItem('USER_ID'),
        nome: ''
    });

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

    const navigate=useNavigate();

    const [message,setMessage] = useState();

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value
        });
    };


    const handleSubmit = (event) => {

        event.preventDefault();

        axiosClient.post('/client',{
            clientData: formData,
            allergie: selectedIds,
            role : role
        })
            .then(({data}) => {

                debugger;
                navigate('/selezioneprofilo');
                setNotificationStatus(data.status);
                setNotification(data.notification);
            })
                .catch(error  => {
                    setMessage(error.notification);
                    console.log(error);
                });
    }

    return(
        <div>
            <h1>Inserisci i tuoi dati</h1>
            {message && <div><p>{message}</p></div>}
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="nome">Username</label>
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
                {allergeni.length === 0 ? (<p>Loading...</p>) : (
                    <div>
                        {allergeni.map((allergene) => {
                            return (
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value={allergene.id}
                                        id={allergene.id}
                                        onChange={(event) => {
                                            handleCheckboxChange(event)
                                        }
                                        }/>
                                    <label class="form-check-label" for={allergene.id}>
                                        {allergene.nome}
                                    </label>
                                </div>);
                        })}
                    </div>)}
                <div>
                    <button type="submit" className="btn btn-primary me-2">Conferma</button>
                    &nbsp; &nbsp;
                    <Link to='/selezioneprofilo' className="btn btn-secondary">Annulla</Link>
                </div>
            </form>
        </div>
    );

}