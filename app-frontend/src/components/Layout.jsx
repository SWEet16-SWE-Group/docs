import {Link, Navigate, Outlet} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";
import axiosClient from "../axios-client";

function Header(){

  const {user, token, role, notification, notificationStatus, setUser, setToken, setRole} = useStateContext()

  if(!token){
    return (
      <header>
          <div> Header </div>
          <Link to="/Ristoranti">Esplora</Link>
          <Link to="/Login">Login</Link>
          <Link to="/SignUp">Sign up</Link>
      </header>
    )
  }

  const onLogout = (ev) => {
      ev.preventDefault()

      axiosClient.post('/logout')
          .then(() => {
              setUser('')
              setToken(null)
              setRole('')
          })
  }

  const onLogoutProfile = (ev) => {
    ev.preventDefault()
    setRole('AUTENTICATO')
  }

  return ({
    'AUTENTICATO':(
        <header>
            <div> Header </div>
            <Link to="/modificainfoaccount" className="btn-info">Profilo</Link>
            <Link to="/selezioneprofilo" className="btn-info">Selezione Profilo</Link>
            <div> {localStorage.USER_ID} </div>
            <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
        </header>
    ),
    'CLIENTE':(
        <header>
            <div> Header </div>
            <a href="/selezioneprofilo" onClick={onLogoutProfile} className="btn-info">Selezione Profilo</a>
            <div> {user.email} </div>
            <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
        </header>
    ),
    'RISTORATORE':(
        <header>
            <div> Header </div>
            <a href="/selezioneprofilo" onClick={onLogoutProfile} className="btn-info">Selezione Profilo</a>
            <div> {user.email} </div>
            <a href="#" onClick={onLogout} className="btn-logout">Logout</a>
        </header>
    ),
  })[role];

}

export default function Layout() {
    const {notification, notificationStatus} = useStateContext()
    return (
        <div id="defaultLayout">
            <aside>
                <Link to="/dashboard">DashBoard</Link>
            </aside>
            <div className="content">
              <Header />

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
    )
}
