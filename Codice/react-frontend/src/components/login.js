import React, { Component } from "react";
import { Navigate } from "react-router-dom";
import axios from 'axios';

class Login extends Component {
    constructor(props) {
        super(props);
        this.state = {
            ristoranti: [],
            clienti: [],
            selectedValue: "",
            submittedClienti: false,
            submittedRistoranti: false,
        };
        this.onButtonClick = this.onButtonClick.bind(this);
    }

    componentDidMount() {
        localStorage.setItem('page', JSON.stringify("Login"));

        axios.post("http://localhost:8888/select_clienti.php ").then(response => {
            this.setState({ clienti: response.data });
        })

        axios.post("http://localhost:8888/select_ristoranti.php ").then(response => {
            this.setState({ ristoranti: response.data });
        })
    }

    onButtonClick = (id, tipo) => (event) => {
        event.preventDefault();
        if (tipo === 'C') {
            localStorage.setItem('idc', this.state.clienti[id].ID_cliente);
            localStorage.setItem('idu', JSON.stringify(this.state.clienti[id].Username));
            this.setState({ submittedClienti: true });
            this.props.handlePage("Dashboard Clienti");
        }
        else {
            localStorage.setItem('idr', this.state.ristoranti[id].ID_ristorante);
            this.setState({ submittedRistoranti: true });
            this.props.handlePage("Dashboard Ristoratori");
        }
        return
    }

    render() {
        return (
            <div className="container-fluid p-auto w-75 border rounded border-2 margin-tb h-auto">
                {this.state.submittedClienti && (
                    <Navigate to="/dashboardclienti"
                    />)}
                {this.state.submittedRistoranti && (
                    <Navigate to="/dashboardristoratori"
                    />)}
                  <h1 className="my-5 d-flex justify-content-center">LOGIN</h1>
                    <div className="row mb-5 mx-3">
                        <div className="col-6" >
                        <h2 className="login-clienti text-center mb-4">Clienti</h2>
                            {this.state.clienti.length !== 0 && this.state.clienti.map((rs, index) => (
                                <div className="row my-1" key={index}>
                                    <div className="col-6">{rs.Username}</div>
                                    <div className="col-6">
                                        <div className="col-1" onClick={this.onButtonClick(index, 'C')}>
                                            <button type="button" className="btn-partecipanti btn btn-sm btn-outline-primary">Seleziona</button>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </ div>
                        <br />
                        <div className=" col-6">
                          <h2 className="login-ristoratori text-center mb-4"> Ristoratori</h2>
                            {this.state.ristoranti.length !== 0 && this.state.ristoranti.map((rs, index) => (
                                <div className="row my-1" key={index}>
                                    <div className="col-6">{rs.Ragione_sociale}</div>
                                    <div className="col-6">
                                        <div className="col-1" onClick={this.onButtonClick(index, 'R')}>
                                            <button type="button" className="btn-partecipanti btn btn-sm btn-outline-primary">Seleziona</button>
                                        </div>
                                    </div>
                                </div>
                            ))}
                    </div>
                </div>
            </div>
        )
    }
}

export default Login
