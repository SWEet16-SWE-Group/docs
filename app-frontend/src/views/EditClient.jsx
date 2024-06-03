import {  useParams , useNavigate} from "react-router-dom";
import {useState , useEffect } from 'react';
import { fetchClientProfile , deleteClientProfile , updateClientProfile } from '../services/ClientService';
import {useStateContext} from "../contexts/ContextProvider";
import axios from 'axios';
import axiosClient from "../axios-client.js";

export default function EditClient() {

    const {id} = useParams();

    const { setNotificationStatus, setNotification}  = useStateContext();

    const [formData, setFormData] = useState({
        id: '',
        nome: '',
        user: localStorage.getItem('USER_ID'),
    });

    const navigate=useNavigate();

    useEffect(() => {
        getClient();
    },[]);

    const handleChange = (e) => {
        setFormData({
            ...formData,
            [e.target.name] : e.target.value,
        });
    };

    const handleSubmit = (event) => {
        event.preventDefault();

        //apiService.get('/client/'.concat(clientId));
        updateClientProfile(formData)
            .then(function (response) {
                // handle success
                setNotification(response.notification);
                setNotificationStatus(response.status);
                navigate("/selezioneprofilo");
                console.log(response);
            })
            .catch(error => {
                // handle error
                //setMessage(error.response.data.message);

            });
    }

   const getClient = () => {

        const payload = {
            id: id,
            userId: formData.user,
            role: localStorage.getItem('ROLE'),
        }

        axiosClient.get(`/client/${id}`)
            .then(({data}) => {

            setFormData(data);
            console.log(data);
            console.log(formData);
       })
        .catch (error =>
        {
            setNotification(error.notification);
            setNotificationStatus(error.status);
        })
    }

    return (
        <div>
                <h1 className="title text-center">Modifica le informazioni relative a questo profilo</h1>
            <div id="editClientForm">
                {formData != null ? (
                    <div>
                        <form>
                            <div class="form-group row">
                                <label for="nome" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nome" name="nome" value={formData.nome}
                                           onChange={handleChange}/>
                                </div>
                            </div>
                            <button onClick={handleSubmit} class="btn btn-primary mb-2">Conferma modifiche</button>
                        </form>
                    </div>) : (
                    <p>Loading...</p>
                )

                }

            </div>
        </div>
    );
}

// <div>  {message && <p>{message}</p>}</div>