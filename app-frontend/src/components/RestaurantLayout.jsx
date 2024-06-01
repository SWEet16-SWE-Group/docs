import {Link, Navigate, Outlet} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";
import axiosClient from "../axios-client";

export default function RestaurantLayout() {

    const {user, token, role, notification,notificationStatus, setUser, setToken, setRole} = useStateContext()

    if (!token) {
        return <Navigate to={"/login"}/>
    }

    if (token && role === 'AUTENTICATO') {
        return <Navigate to={"/selezionaprofilo"}/>
    }

    if (token && role === 'CLIENTE') {
        return <Navigate to={"/dashboardcliente"}/>
    }
    debugger;

    if (token && role === 'RISTORATORE') {
        const onLogout = (ev) => {
            ev.preventDefault()

            axiosClient.post('/logout')
                .then(() => {
                    setUser('')
                    setToken(null)
                    setRole('')
                })
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
                                {user.email}
                                <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
                            </div>
                        </header>

                        <main>
                            <div>Ristoratore!</div>
                            <Outlet/>

                            {notification &&
                                <div className={`notification ${notificationStatus}`}>
                                    {notification}
                                </div>
                            }
                        </main>
                    </div>
                </div>
            </>
        )
    }
}