import {useEffect, useRef, useState} from "react";
import axiosClient from "../axios-client";
import {get} from "axios";
import {Link, Navigate, redirect} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";

export default function SelezioneProfilo() {


    const {role, setRole, setProfile, setNotification, setNotificationStatus } = useStateContext()
    const [profiles, setProfiles] = useState(null);


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

                setProfiles(data);
                debugger;
            })
    }

    useEffect(() => {

        getProfiles();
    }, [])


    const onSelectProfile = (ev) => {
        ev.preventDefault();

        // TODO funzione che seleziona il profilo
    }

    const onModifyProfile = (ev) => {
        ev.preventDefault();

        // TODO creare funzione che ti porta alla pagina di modifica profilo
    }

    const onDeleteProfile = (ev) => {
        ev.preventDefault();

        // TODO creare funzione che elimina il profilo
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
                <table>
                    <thead>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Operazioni</th>
                    </thead>
                    <tbody>
                    {profiles && profiles.map(p => (
                        <tr>
                            <td>
                                <button onClick={onSelectProfile(p)}>Seleziona</button>
                            </td>
                            <td>{p.id}</td>
                            <td>{p.nome}</td>
                            <td>{p.tipo}</td>
                            <td>
                                <button onClick={onModifyProfile(p)}>Modifica</button>
                                <button onClick={onDeleteProfile(p)}>Elimina</button>
                            </td>
                        </tr>
                    ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
}