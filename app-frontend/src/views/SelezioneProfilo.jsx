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
            navigate('/editClient', {state: { id: profile.id}});
        } else if (profile.tipo === 'Ristoratore')
        {
           navigate(`/modificaprofiloristoratore/${profile.id}`);
        }
    }

    const onDeleteProfile = async (profile) => {

        console.log("dentro elimina ", profile.id);

        if(!window.confirm("Sei sicuro di voler eliminare questo profilo?")) {
            return
        }

       if(profile.tipo === 'Cliente') {
           try {
               const response = await axiosClient.delete(`/client/${profile.id}`);
               setNotificationStatus('success');
               setNotification('Ristoratore eliminato con successo.');
           } catch (error) {
               setNotificationStatus('failure');
               setNotification('Errore durante l\'eliminazione del cliente.');
               console.error(error);
           }

       } else if(profile.tipo === 'Ristoratore') {

           try {
               const response = await axiosClient.delete(`/elimina-ristoratore/${profile.id}`);
               setNotificationStatus('success');
               setNotification('Ristoratore eliminato con successo.');
           } catch (error) {
               setNotificationStatus('failure');
               setNotification('Errore durante l\'eliminazione del ristoratore.');
               console.error(error);
           }
       }
    }

    return (
        <div className="container-fluid p-auto border rounded border-2 margin-tb h-auto">
            <div>
                <Link to={'/newclient'}>Crea nuovo profilo cliente</Link>
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