import {Link, useNavigate, Outlet} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";
import axiosClient from "../axios-client";

function Header(){

  const {user, token, role, notification, notificationStatus, setUser, setProfile, setToken, setRole} = useStateContext()
  const navigate = useNavigate();

  const onLogout = (ev) => {
    ev.preventDefault()
    setUser(null)
    setToken(null)
    setProfile(null)
    setRole('ANONIMO')
    navigate('/login')
  }

  const onLogoutProfile = (ev) => {
    ev.preventDefault()
    setRole('AUTENTICATO')
    setProfile(null)
    navigate('/selezioneprofilo')
  }

  const defaultHeader = (
      <header>
          <div> {role} </div>
          <Link to="/ristoranti">Esplora</Link>
          <Link to="/login">Login</Link>
          <Link to="/signup">Sign up</Link>
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
            <Link to="#" onClick={onLogout} className="btn-logout">Logout</Link>
        </header>
    ),
    'CLIENTE':(
        <header>
            <div> {role} </div>
            <Link to="/Ristoranti">Prenota</Link>
            <Link to="/selezioneprofilo" onClick={onLogoutProfile} className="btn-info">Selezione Profilo</Link>
            <div> {user} </div>
            <Link to="#" onClick={onLogout} className="btn-logout">Logout</Link>
        </header>
    ),
    'RISTORATORE':(
        <header>
            <div> {role} </div>
            <Link to="/selezioneprofilo" onClick={onLogoutProfile} className="btn-info">Selezione Profilo</Link>
            <div> {user} </div>
            <Link to="#" onClick={onLogout} className="btn-logout">Logout</Link>
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
