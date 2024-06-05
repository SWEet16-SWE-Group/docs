import {Link, Navigate, Outlet} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";
import axiosClient from "../axios-client";

function Header(){

  const {user, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()

  const onLogout = (ev) => {
    ev.preventDefault()
    setUser('')
    setToken(null)
    setRole('ANONIMO')
  }

  const onLogoutProfile = (ev) => {
    ev.preventDefault()
    setRole('AUTENTICATO')
  }

  const defaultHeader = (
      <header>
          <div> {role} </div>
          <Link to="/Ristoranti">Esplora</Link>
          <Link to="/Login">Login</Link>
          <Link to="/SignUp">Sign up</Link>
      </header>
  )

  return ({
    '': defaultHeader,
    'null': defaultHeader,
    null: defaultHeader,
    undefined: defaultHeader,
    'ANONIMO': defaultHeader,
    'AUTENTICATO':(
        <header>
            <div> {role} </div>
            <Link to="/modificainfoaccount" className="btn-info">Profilo</Link>
            <Link to="/selezioneprofilo" className="btn-info">Selezione Profilo</Link>
            <div> {localStorage.USER_ID} </div>
            <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
        </header>
    ),
    'CLIENTE':(
        <header>
            <div> {role} </div>
            <a href="/selezioneprofilo" onClick={onLogoutProfile} className="btn-info">Selezione Profilo</a>
            <div> {user} </div>
            <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
        </header>
    ),
    'RISTORATORE':(
        <header>
            <div> {role} </div>
            <a href="/selezioneprofilo" onClick={onLogoutProfile} className="btn-info">Selezione Profilo</a>
            <div> {user} </div>
            <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
        </header>
    ),
  })[role];

}

export default function Layout() {

    const {user, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()

    return (
        <div id="defaultLayout">
            <aside>
                <Link to="/dashboard">DashBoard</Link>
            </aside>
            <div className="content">
              <Header />

                <main>
                    <div> {role}! </div>
                    <Outlet/>

                    {notification &&
                        <div className={`notification ${notificationStatus}`}>
                            {notification}
                        </div>
                    }
                </main>
            </div>
        </div>
    )
}
