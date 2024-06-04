import {useEffect, useRef, useState} from "react";
import axiosClient from "../axios-client";
import {get} from "axios";
import {Link, useNavigate, redirect} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";

export default function SelezioneProfilo() {

    const navigate = useNavigate();

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

                setNotificationStatus(data.status);
                setNotification(data.notification);
                console.log(data.profile);

            })
            .catch(err => {
                    const response = err.response;
                    if(response && response.status === 422) {
                        redirect('/');
                    }
                }
            );
    }

    const onModifyProfile = (profile) => {

        console.log("dentro modifica ", profile.id);
        console.log(profile.tipo);

        if(profile.tipo === 'Cliente')
        {
            navigate(`/modificaprofilocliente/${profile.id}`);
        } else if (profile.tipo === 'Ristoratore')
        {
           navigate(`/modificaprofiloristoratore/${profile.id}`);
        }
    }

    const onDeleteProfile =  (profile) => {

        console.log("dentro elimina ", profile.id);

        if(!window.confirm("Sei sicuro di voler eliminare questo profilo?")) {
            return
        }

       if(profile.tipo === 'Cliente') {

           axiosClient.delete(`/client/${profile.id}`)
               .then(({data}) => {

                   setNotificationStatus(data.status);
                   setNotification(data.notification);
                   getProfiles();

           })
               .catch(data =>  {
                   setNotificationStatus(data.status);
                   setNotification(data.notification);
           })

       } else if(profile.tipo === 'Ristoratore') {

       }
           axiosClient.delete(`/elimina-ristoratore/${profile.id}`)
               .then(({data}) => {

                   setNotificationStatus(data.status);
                   setNotification(data.notification);
                   getProfiles();

               })
               .catch(data =>  {
                   setNotificationStatus(data.status);
                   setNotification(data.notification);
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
                                <button className="btn btn-primary me-2" onClick={() =>onSelectProfile(profile)}>Seleziona</button>
                            </td>
                            <td>{profile.nome}</td>
                            <td>{profile.tipo}</td>
                            <td>
                                <button className="btn btn-primary me-2" onClick={() => onModifyProfile(profile)}>Modifica</button>
                                &nbsp;
                                <button className="btn btn-primary me-2" onClick={() => onDeleteProfile(profile)}>Elimina</button>
                            </td>
                        </tr>
                    ))}
                    {RestaurantProfiles && RestaurantProfiles.map(profile => (
                        <tr>
                        <td>
                            <button className="btn btn-primary me-2" onClick={() => onSelectProfile(profile)}>Seleziona</button>
                        </td>
                            <td>{profile.nome}</td>
                            <td>{profile.tipo}</td>
                            <td>
                                <button className="btn btn-primary me-2" onClick={() => onModifyProfile(profile)}>Modifica</button>
                                &nbsp;
                                <button className="btn btn-primary me-2" onClick={() => onDeleteProfile(profile)}>Elimina</button>
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