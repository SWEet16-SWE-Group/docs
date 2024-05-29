import {Link, Navigate, Outlet, redirect, useNavigate} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";
import axiosClient from "../axios-client";


export default function AuthenticatedLayout() {

    const {user, token, role, setUser, setToken, setRole} = useStateContext()

    if (!token) {
        return <Navigate to={"/login"}/>
    }

    if(token && role === 'CLIENTE') {
        return <Navigate to={"/dashboardcliente"}/>
    }

    if(token && role === 'RISTORATORE') {
        return <Navigate to={"/dashboardristoratore"}/>
    }

    if (token && role === 'AUTENTICATO') {

        const onLogout = (ev) => {
            ev.preventDefault()

            axiosClient.post('/logout')
                .then(() => {
                    setUser('')
                    setToken(null)
                    setRole('')
                })
        }


        const goToModificaAccountInfo = () => {
            Navigate("/modificainfoaccount");
        }
        return (
            <>
                <div id="defaultLayout">
                    <aside>
                        <Link to="/dashboard">DashBoard</Link>
                    </aside>
                    <div className="content">
                        <header>
                            <div>
                                Header
                            </div>
                            <div>
                                <Link to="/modificainfoaccount" className="btn-info">Profilo</Link>
                            </div>
                            <div>
                                {localStorage.USER_ID}
                                <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
                            </div>
                        </header>

                        <main>

                            <div>Autenticato!</div>
                            <Outlet/>
                        </main>
                    </div>
                </div>
            </>
        )
    }
}