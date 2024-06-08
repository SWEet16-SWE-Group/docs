import {useParams, useNavigate, Link} from "react-router-dom";
import React, {useState , useEffect }  from 'react';
import { fetchClientProfile , deleteClientProfile , updateClientProfile } from '../services/ClientService';
import {useStateContext} from "../contexts/ContextProvider";
import axios from 'axios';
import axiosClient from "../axios-client.js";
import { act } from "react";

export default function ModificaProfiloCliente() {

    const [errors, setErrors] = useState(null);
    const {id} = useParams();
    const {role,setNotificationStatus, setNotification}  = useStateContext();
    const user_id = localStorage.getItem('USER_ID');
    const [username, setUsername] = useState('');
    const navigate=useNavigate();

    useEffect(() => {
        getClient();
    },[]);

    const handleSubmit = (event) => {
        event.preventDefault();

        const payload = {
            id: id,
            user: user_id,
            nome: username,
            role: role,
        }

        axiosClient.put('/client',payload)
            .then(({data}) => {
                // handle success

                navigate("/selezioneprofilo");
                setNotificationStatus(data.status);
                setNotification(data.notification);
            })
            .catch(error => {
                    setErrors(error.response.data.errors);
                });
    }

   const getClient = () => {

        const payload = {
            id: id,
            user: user_id,
            role: role,
        }

        axiosClient.get(`/client/${id}`)
            .then(({data}) => {

            setUsername(data.nome);
            console.log(data);
       })
        .catch (error =>
        {
            setErrors('Errore durante il recupero dei dati.');
            console.error(error);
        })
    }

    return (
        <div>
                <h1 className="title text-center">Modifica le informazioni relative a questo profilo</h1>
            <div id="editClientForm">
                {errors && <div className="alert">
                    {Object.keys(errors).map(key => (
                        <p key={key}>{errors[key][0]}</p>
                    ))}
                </div>
                }
                <div>
                    <form>
                        <div class="form-group row">
                            <label for="nome" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nome" name="nome" value={username} role="nameChanger"
                                       onChange={ev =>
                                           setUsername(ev.target.value)}
                                required
                                />
                            </div>
                        </div>
                        <div>
                        <button onClick={handleSubmit} class="btn btn-primary mb-2">Conferma modifiche</button>
                        &nbsp; &nbsp;
                        <Link to='/selezioneprofilo' className="btn btn-secondary">Annulla</Link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
}