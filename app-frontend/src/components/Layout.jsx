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
            <Link to="/Ristoranti">Prenota</Link>
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

function LinkDashboard(){
  const {user, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()
  const defaultLink = (<Link to="/ristoranti">Dashboard</Link>);
  return ({
    '': defaultLink,
    'null': defaultLink,
    null: defaultLink,
    undefined: defaultLink,
    'ANONIMO': defaultLink,
    'AUTENTICATO':(<Link to="/selezioneprofilo">Dashboard</Link>),
    'CLIENTE':    (<Link to="/dashboardcliente">Dashboard</Link>),
    'RISTORATORE':(<Link to="/dashboardristoratore">Dashboard</Link>),
  })[role];
}

export default function Layout({Content}) {

    const {user, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()

    return (
        <div id="defaultLayout">
            <aside>
                <LinkDashboard />
            </aside>
            <div className="content">
              <Header />

                <main>
                    <div> {role}! </div>
                    {Content}

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
