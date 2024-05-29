import {useEffect, useRef, useState} from "react";
import axiosClient from "../axios-client";
import {get} from "axios";
import {Link, Navigate, redirect} from "react-router-dom";

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

    const getUser = () => {

        const payload = {
            id: user.id
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
            password: user.password,
            password_confirmation: user.password_confirmation
        };

        axiosClient.put(`/userpassword`, payload)
            .then(({}) => {
                // TODO show notification
                console.log('password modificata');
                window.location.reload();

            })
            .catch(err => {
                const response = err.response;
                if(response && response.status === 422) {
                    console.error(response.data);
                    console.log(response.data.errors);
                    setErrorsPassword(response.data.errors);
                }
            })
    }

    const onModifyEmail = (ev) => {

        ev.preventDefault()
        setErrorsEmail(null);

        const payload = {
            id: user.id,
            email: user.email,
        };

        axiosClient.put(`/useremail`, payload)
            .then(({}) => {
                // TODO show notification
            })
            .catch(err => {

                const response = err.response;
                if(response && response.status === 422) {
                    console.error(response.data);
                    console.log(response.data.errors);
                    setErrorsEmail(response.data.errors);
                }
            })
    }

    const onDelete = (ev) => {
        ev.preventDefault();

        if(!window.confirm("Sei sicuro di voler eliminare il tuo account?")) {
            return
        }

        const payload = {
            id: user.id
        };

        axiosClient.delete(`/user`,{ data: payload })
            .then(() => {
                // TODO show notification
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