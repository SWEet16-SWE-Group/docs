import {Link, useNavigate} from "react-router-dom";
import axiosClient from "../axios-client.js";
import {createRef} from "react";
import {useStateContext} from "../contexts/ContextProvider.jsx";
import { useState } from "react";

export default function Login() {
    const emailRef = createRef()
    const passwordRef = createRef()

    const navigate= useNavigate();
    const { setUser, setToken, setRole, setNotificationStatus, setNotification} = useStateContext()
    const [message, setMessage] = useState(null)

    const onSubmit = ev => {
        ev.preventDefault()
        const payload = {
            email: emailRef.current.value,
            password: passwordRef.current.value,
        }
        axiosClient.post('/login', payload)
            .then(({data}) => {

                setUser(data.user['id'])
                setRole(data.role);
                setToken(data.token);

                navigate('/selezioneprofilo');
                setNotificationStatus('success');
                setNotification('Login effettuato con successo');


                //debugger;
            })
            .catch((err) => {
                const response = err.response;
                if (response && response.status === 422) {
                    setMessage(response.data.message)

                }
                //debugger;
            })

    }

    return (
        <div className="login-signup-form animated fadeInDown">
            <div className="form">
                <form onSubmit={onSubmit}>
                    <h1 className="title"> Effettua il login nel tuo account
                    </h1>

                    {message &&
                        <div className="alert">
                            <p>{message}</p>
                        </div>
                    }

                    <input ref={emailRef} type="email" placeholder="Email"/>
                    <input ref={passwordRef} type="password" placeholder="Password"/>
                    <button className="btn btn-block">Login</button>
                    <p className="message">Non registrato? <Link to="/signup">Crea un account</Link></p>
                </form>
            </div>
        </div>
    )
}