import {Link} from "react-router-dom";

export default function SignUp() {

    const onSubmit = (ev) => {
        ev.preventDefault()
    }

    return (
        <div className="login-signup-form animated fadeInDown" >
            <div className="form">
                <form onSubmit={onSubmit}>
                    <h1 className="title">Registrazione account</h1>
                    <input type="email" placeholder=" Email" />
                    <input type="password" placeholder=" Password"/>
                    <input type="password" placeholder=" Ripeti password"/>
                    <button className="btn btn-block">Registrati</button>
                    <p className="message">
                        Sei già registrato?  <Link to="/login"> Vai a login</Link>
                    </p>
                </form>
            </div>
        </div>
    )
}