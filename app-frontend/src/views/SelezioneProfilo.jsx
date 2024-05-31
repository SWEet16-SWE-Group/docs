import {useEffect, useRef, useState} from "react";
import axiosClient from "../axios-client";
import {get} from "axios";
import {Link, Navigate, redirect} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";

export default function SelezioneProfilo() {


    const {role, setRole, setProfile, setNotification, setNotificationStatus } = useStateContext()
    const [ClientProfiles, setClientProfiles] = useState(null);
    const [RestaurantProfiles, setRestaurantProfiles] = useState(null);


    const [user, setUser] = useState({
        id: localStorage.getItem('USER_ID'),
    })

    const getProfiles = () => {

        const $payload = {
            id: user.id,
            role: role
        };

        axiosClient.post('/profiles',$payload)
            .then(({data}) => {

                setClientProfiles(data.clienti);
                setRestaurantProfiles(data.ristoratori);
                console.log(data);
                debugger;
            })
            .catch(err => {
                const response = err.response;
                console.error(response);
            })
    }

    useEffect(() => {

        getProfiles();
    }, [])


    /*const onSelectProfile = (p) => {
        p.preventDefault();

        // TODO funzione che seleziona il profilo
    }

    const onModifyProfile = (p) => {
        p.preventDefault();

        // TODO creare funzione che ti porta alla pagina di modifica profilo
    }

    const onDeleteProfile = (p) => {
        p.preventDefault();

        // TODO creare funzione che elimina il profilo
    }*/

    return (
        <div className="container-fluid p-auto border rounded border-2 margin-tb h-auto">
            <div>
                <Link to={'/creazioneprofilocliente'}>Crea nuovo profilo cliente</Link>
            </div>
            <div>
                <Link to={'/creazioneprofiloristoratore'}>Crea nuovo profilo ristoratore</Link>
            </div>
            <div>
                {(!ClientProfiles && !RestaurantProfiles) &&
                    <h2>
                        Non è presente nessun profilo, creane uno!
                    </h2>
                }
                {(ClientProfiles || RestaurantProfiles) &&
                    <table>
                    <thead>
                    <th>Entra con questo profilo</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Operazioni</th>
                    </thead>
                    <tbody>
                    {ClientProfiles && ClientProfiles.map(p => (
                        <tr>
                            <td>
                                <button >Seleziona</button>
                            </td>
                            <td>{p.nome}</td>
                            <td>Cliente</td>
                            <td>
                                <button >Modifica</button>
                                <button >Elimina</button>
                            </td>
                        </tr>
                    ))}
                    {RestaurantProfiles && RestaurantProfiles.map(p => (
                        <tr>
                            <td>
                                <button >Seleziona</button>
                            </td>
                            <td>{p.nome}</td>
                            <td>Ristoratore</td>
                            <td>
                                <button >Modifica</button>
                                <button >Elimina</button>
                            </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
                }
            </div>
        </div>
    );
}