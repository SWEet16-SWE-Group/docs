import {Link, Navigate, Outlet} from "react-router-dom";
import {useStateContext} from "../contexts/ContextProvider";

export default function GuestLayout() {

    const {token} = useStateContext()

    if(token) {
        return <Navigate to={"/"} />
    }
    return (
        <>
          <div id="defaultLayout">
              <aside>
                  <Link to="/">DashBoard</Link>
              </aside>
              <div className="content">
                  <header>
                      <div>
                          Header
                      </div>
                      <Link to="/">Esplora</Link>
                      <Link to="/Login">Login</Link>
                      <Link to="/SignUp">Sign up</Link>
                  </header>

                  <main>
                      <Outlet/>
                  </main>
              </div>
          </div>
        </>
    )
}
