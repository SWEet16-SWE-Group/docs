import React, { Component } from 'react';
import { Link, Outlet } from 'react-router-dom';
import axios from 'axios';

class Navbar extends Component {
  constructor(props) {
    super(props);
    this.state = {
      pageName : "Dashboard Cliente",
      cliente : []
    }
    this.handlePage = this.handlePage.bind(this);
  }
    
    componentDidMount() 
    {  
      axios.get("http://localhost:8888/select_single_cliente.php").then(response => {
        this.setState({ cliente: response.data });
      });
    }

    handlePage = (selectedPage) => {
      this.setState({ pageName: selectedPage });
    };


      render() 
      {
        const {pageName} = this.state;

          return (
             pageName !== "Login" && (
              <>
              <nav className="navbar navbar-dark bg-dark fixed-top">
                    <div className="container-fluid d-flex justify-content-between">
                        <div className="navbar-brand h1">
                          <button className="btn btn-dark btn-lg fw-bold" type="button" data-bs-toggle="offcanvas" data-bs-target="#apriMenu" aria-controls="offcanvasWithBothOptions">Menu</button>

                            <div className="offcanvas offcanvas-start" data-bs-scroll="true" tabIndex="-1" id="apriMenu" aria-labelledby="offcanvasWithBothOptionsLabel">
                              <div className="offcanvas-header">
                                <h3 className="offcanvas-title" id="offcanvasWithBothOptionsLabel">{pageName}</h3>
                                <button type="button" className="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                              </div>
                              <div className="offcanvas-body">
                                <ul className="list-group list-group-flush">
                                  {pageName === "Dashboard Cliente" && (
                                  <li className="list-group-item">
                                    <Link to="/form_prenotazione" className="text-decoration-none text-black" onClick={() =>this.handlePage("Form Prenotazione")}>Form Prenotazione</Link>
                                  </li>
                                  )}
                                  {pageName === "Form Prenotazione" && (
                                  <li className="list-group-item">
                                    <Link to="/dashboard_cliente" className="text-decoration-none text-black" onClick={() =>this.handlePage("Dashboard Cliente")}>Dashboard Cliente</Link>
                                  </li>
                                  )}
                                  <li className="list-group-item">
                                    <Link to="/login" className="text-decoration-none text-black" onClick={() =>this.handlePage("Login")}>Logout</Link>
                                  </li>
                                </ul>
                              </div>
                            </div>
                        </div>
                        <div className="navbar-brand h1">Easymeal</div>
                        {this.state.cliente.map((rs, index) => (
                          <div key={index} className="navbar-brand h1">{rs.Username}</div>
                        ))}
                    </div>
                </nav>

            <Outlet />
            </>
            )
          );
        }
}
          
export default Navbar;