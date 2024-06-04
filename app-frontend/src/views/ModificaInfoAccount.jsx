import {useEffect, useRef, useState} from "react";
import axiosClient from "../axios-client";
import {get} from "axios";
import {Link, Navigate, redirect} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";

export default function ModificaInfoAccount() {

    useEffect(() => {
        getUser();
    }, []);

    const [user, setUser] = useState({
        id: localStorage.getItem('USER_ID'),
        email: '',
        password: '',
        password_confirmation: ''
    })

    const [errorsEmail, setErrorsEmail] = useState(null);
    const [errorsPassword, setErrorsPassword] = useState(null);
    const {role, setRole, setNotification, setNotificationStatus} = useStateContext();
    setRole(localStorage.getItem('ROLE'));

    const getUser = () => {

        const payload = {
            id: user.id,
            role: role
        };
        axiosClient.post('/user',payload)
            .then(({data}) => {

            setUser(data);
            console.log(user.email);
            })
            .catch(err => {
                const response = err.response;
                if(response && response.status === 422) {
                    redirect('/');
                }
            }
        );
    }

    const onModifyPassword = (ev) => {

        ev.preventDefault()
        setErrorsPassword(null);

        const payload = {
            id: user.id,
            role: role,
            password: user.password,
            password_confirmation: user.password_confirmation
        };

        axiosClient.put(`/userpassword`, payload)
            .then(({}) => {

                console.log('password modificata');
                setNotificationStatus('success')
                setNotification("Password modificata con successo");

            })
            .catch(err => {
                const response = err.response;
                if(response && response.status === 422) {
                    console.error(response.data);
                    console.log(response.data.errors);

                    setNotificationStatus('failure');
                    setNotification(response.data.errors.password);

                    debugger;
                }
            })
    }

    const onModifyEmail = (ev) => {

        ev.preventDefault()
        setErrorsEmail(null);

        const payload = {
            id: user.id,
            role: role,
            email: user.email,
        };

        axiosClient.put(`/useremail`, payload)
            .then(({}) => {
                setNotificationStatus('success');
                setNotification("Email modificata con successo");
            })
            .catch(err => {

                const response = err.response;
                if(response && response.status === 422) {
                    console.error(response.data);
                    console.log(response.data.errors);

                    setNotificationStatus('failure');
                    setNotification(response.data.errors.email);

                    debugger;
                }
            })
    }

    const onDelete = (ev) => {
        ev.preventDefault();

        if(!window.confirm("Sei sicuro di voler eliminare il tuo account?")) {
            return
        }

        const payload = {
            id: user.id,
            role: role
        };

        axiosClient.delete(`/user`,{ data: payload })
            .then(() => {

                setNotificationStatus('success');
                setNotification("Account eliminato con successo");

                localStorage.clear();
                window.location.reload();
            })
    }

    return (

        <div className="form">

            <h1 className="title text-center">Modifica le informazioni relative al tuo account</h1>

            <form onSubmit={onModifyPassword}>
                <h2>Modifica password:</h2>
                {errorsPassword && <div className="alert">
                    {Object.keys(errorsPassword).map(key => (
                        <p key={key}>{errorsPassword[key][0]}</p>
                    ))}
                </div>
                }
                <input onChange={ev => setUser({...user, password: ev.target.value})} type="password"
                       placeholder=" Nuova Password"/>
                <input onChange={ev => setUser({...user, password_confirmation: ev.target.value})} type="password"
                       placeholder=" Ripeti nuova password"/>
                <button className="btn btn-block">Salva</button>
            </form>

            <form onSubmit={onModifyEmail}>
                <h2>Modifica email:</h2>
                {errorsEmail && <div className="alert">
                    {Object.keys(errorsEmail).map(key => (
                        <p key={key}>{errorsEmail[key][0]}</p>
                    ))}
                </div>
                }
                <input onChange={ev => setUser({...user, email: ev.target.value})} value={user.email} type="email"
                       required/>
                <button className="btn btn-block">Salva</button>
            </form>

            <form onSubmit={onDelete}>
                <button className="btn btn-delete">Elimina account</button>
            </form>
        </div>

    )


}