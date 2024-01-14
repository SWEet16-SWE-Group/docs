import React, { Component } from "react";
import { Navigate } from "react-router-dom";
import axios from 'axios';
import "../App.css";

class login extends Component {
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
        }
        else {
            localStorage.setItem('idr', this.state.ristoranti[id].ID_ristorante);
            this.setState({ submittedRistoranti: true });
        }
        return
    }

    render() {
        return (
            <div >
                {this.state.submittedClienti && (
                    <Navigate to="/dashboardclienti"
                    />)}
                {this.state.submittedRistoranti && (
                    <Navigate to="/dashboardristoratori"
                    />)}
                <br></br>
                <h1 className="my-5 d-flex justify-content-center">Login</h1>
                <br />
                <h2 className="login-clienti">Clienti</h2>
                <h2 className="login-ristoratori"> Ristoratori</h2>
                <div className="inputContainer">
                    <div>
                        <form className="login-clienti" >
                            {this.state.clienti.length !== 0 && this.state.clienti.map((rs, index) => (
                                <tr key={index}>
                                    <td>{rs.Username}</td>
                                    <td>
                                        <div className="col-1" onClick={this.onButtonClick(index, 'C')}>
                                            <button type="button" className="btn-partecipanti btn btn-sm btn-outline-primary">Seleziona</button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </ form>
                        <br />
                        <form className="login-ristoratori">
                            {this.state.ristoranti.length !== 0 && this.state.ristoranti.map((rs, index) => (
                                <tr key={index}>
                                    <td>{rs.Ragione_sociale}</td>
                                    <td>
                                        <div className="col-1" onClick={this.onButtonClick(index, 'R')}>
                                            <button type="button" className="btn-partecipanti btn btn-sm btn-outline-primary">Seleziona</button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </form>
                        <div></div>
                    </div>
                </div>
            </div>
        )
    }
}

export default login
