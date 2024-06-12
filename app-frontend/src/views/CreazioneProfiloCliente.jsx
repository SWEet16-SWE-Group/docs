import React, { useEffect} from "react";
import {useState} from "react";
import {Link, useNavigate} from "react-router-dom";
import axios from "axios";
import { fetchAllergeni } from "../services/IntolleranzeService";
import {useStateContext} from "../contexts/ContextProvider";
import axiosClient from "../axios-client.js";

export default function CreazioneProfiloCliente() {
    const [errors, setErrors] = useState(null);
    const navigate= useNavigate();
    const {role, setNotification, setNotificationStatus } = useStateContext();
    const user_id = localStorage.getItem('USER_ID');
    const [username, setUsername] = useState('');
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


    const handleSubmit = (event) => {

        event.preventDefault();

        const payload = {
            nome: username,
            user: user_id,
            allergie: selectedIds,
            role : role
        };


        axiosClient.post('/client',payload)
            .then(({data}) => {

                navigate('/selezioneprofilo');
                setNotificationStatus(data.status);
                setNotification(data.notification);
            })
                .catch(error  => {
                    setErrors(error.response.data.errors);
                });
    }

    return(
        <div>
            <h1>Inserisci i tuoi dati</h1>
            {errors && <div className="alert">
                {Object.keys(errors).map(key => (
                    <p key={key}>{errors[key][0]}</p>
                ))}
            </div>
            }
            <form onSubmit={handleSubmit}>
                <div className="mb-3">
                    <label htmlFor="nome">Username</label>
                    <input
                        type="text"
                        className="form-control"
                        id="nome"
                        name="nome"
                        value={username}
                        onChange={ev =>
                            setUsername(ev.target.value)}
                        required
                    />
                </div>
                {allergeni.length === 0 ? (<p>Loading...</p>) : (
                    <div>
                        <p>Seleziona uno o più allergeni a cui sei allergico: </p>
                        <br />
                        {allergeni.map((allergene) => {
                            return (
                                <div key={allergene.id} className="form-check flex">
                                    <input
                                        className="form-check-input"
                                        type="checkbox"
                                        value={allergene.id}
                                        id={allergene.id}
                                        onChange={(event) => {
                                            handleCheckboxChange(event)
                                        }
                                        }/>
                                    <label className="form-check-label" htmlFor={allergene.id}>
                                        {allergene.nome}
                                    </label>
                                </div>
                                );
                        })}
                    </div>)}
                <br />
                <div>
                    <button type="submit" className="btn btn-primary me-2">Conferma</button>
                    &nbsp; &nbsp;
                    <Link to='/selezioneprofilo' className="btn btn-secondary">Annulla</Link>
                </div>
            </form>
        </div>
    );

}
