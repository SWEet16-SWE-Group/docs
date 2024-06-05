import {Link, useNavigate} from "react-router-dom";
import {useRef, useState} from "react";
import axiosClient from "../axios-client";
import {useStateContext} from "../contexts/ContextProvider";

export default function SignUp() {

    const emailRef = useRef();
    const passwordRef = useRef();
    const passwordConfirmationRef = useRef();

    const navigate= useNavigate();
    const [errors, setErrors] = useState(null)
    const {setUser, setToken, setRole, setNotificationStatus, setNotification} = useStateContext()

    const onSubmit = (ev) => {
        ev.preventDefault()
        const payload = {
            email: emailRef.current.value,
            password: passwordRef.current.value,
            password_confirmation: passwordConfirmationRef.current.value,
        }
        console.log(payload);
        axiosClient.post('/signup', payload)
            .then(({data}) => {
                setUser(data.user['id'])
                setRole(data.role)
                setToken(data.token)

                navigate('/selezioneprofilo');
                setNotificationStatus('success')
                setNotification('Registrazione effettuata con successo')
            })
            .catch(err => {
                const response = err.response;
            if(response && response.status === 422) {
                    console.error(response.data);
                    console.log(response.data.errors);
                    setErrors(response.data.errors);
                }
            })
    }

    return (
        <div className="login-signup-form animated fadeInDown" >
            <div className="form">
                <form onSubmit={onSubmit}>
                    <h1 className="title">Registrazione account</h1>

                    {errors && <div className="alert">
                        {Object.keys(errors).map(key => (
                            <p key={key}>{errors[key][0]}</p>
                            ))}
                    </div>
                    }
                    <input ref={emailRef} type="email" placeholder=" Email" />
                    <input ref={passwordRef} type="password" placeholder=" Password"/>
                    <input ref={passwordConfirmationRef} type="password" placeholder=" Ripeti password"/>
                    <button className="btn btn-block">Registrati</button>
                    <p className="message">
                        Sei già registrato?  <Link to="/login"> Vai a login</Link>
                    </p>
                </form>
            </div>
        </div>
    )
}