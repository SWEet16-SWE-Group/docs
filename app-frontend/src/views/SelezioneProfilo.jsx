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


            })
            .catch(err => {
                const response = err.response;
                console.error(response);
            })
    }

    useEffect(() => {
        getProfiles();
    }, [])


    const onSelectProfile = (profile) => {

        const payload = {
            userId: user.id,
            profileId: profile.id,
            profileType: profile.tipo,
            role: role
        }
        axiosClient.post('/selectprofile',payload)
            .then(({data}) => {

                setProfile(data.profile);
                setRole(data.role);

                console.log(data.profile);
            })
            .catch(err => {
                    const response = err.response;
                    if(response && response.status === 422) {
                        redirect('/');
                    }
                }
            );

        // TODO funzione che seleziona il profilo
    }

    const onModifyProfile = (profile) => {

        console.log("dentro modifica ", profile.id);
        // TODO creare funzione che ti porta alla pagina di modifica profilo
    }

    const onDeleteProfile = (profile) => {

        console.log("dentro elimina ", profile.id);

        if(!window.confirm("Sei sicuro di voler eliminare il tuo account?")) {
            return
        }

        const payload = {
            id: profile.id,
            role: role
        };

        axiosClient.delete(`/profiles`,{ data: payload })
            .then(() => {

                setNotificationStatus('success');
                setNotification("Account eliminato con successo");

                localStorage.clear();
                window.location.reload();
            })
    }

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
                    {ClientProfiles && ClientProfiles.map(profile => (
                        <tr>
                            <td>
                                <button onClick={() =>onSelectProfile(profile)}>Seleziona</button>
                            </td>
                            <td>{profile.nome}</td>
                            <td>{profile.tipo}</td>
                            <td>
                                <button onClick={() => onModifyProfile(profile)}>Modifica</button>
                                <button onClick={() => onDeleteProfile(profile)}>Elimina</button>
                            </td>
                        </tr>
                    ))}
                    {RestaurantProfiles && RestaurantProfiles.map(profile => (
                        <tr>
                        <td>
                            <button onClick={() => onSelectProfile(profile)}>Seleziona</button>
                        </td>
                            <td>{profile.nome}</td>
                            <td>{profile.tipo}</td>
                            <td>
                                <button onClick={() => onModifyProfile(profile)}>Modifica</button>
                                <button onClick={() => onDeleteProfile(profile)}>Elimina</button>
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