import React, { Component } from "react";
import axios from 'axios';
import "../App.css";

import Navbar from "./navbar";

class DashboardRistoratori extends Component {
  constructor(props) {
    super(props);
    this.state = {
      inattesa: [],
      accettate: [],
      rifiutate: [],
      ristorante: [],
      cliente: [],
      submittedBack: false,
    };
  }

  componentDidMount() {
    let id_ristorante = -1;
    if (localStorage && localStorage.getItem('idr')) { id_ristorante = JSON.parse(localStorage.getItem('idr')) }
    this.setState({ id_ristorante: id_ristorante });
    const ricerca_ristorante = [
      {
        id_ristorante: id_ristorante,
      }
    ]
    axios.post("http://localhost:8888/select_ristorante.php ", ricerca_ristorante[0]).then(response => {
      this.setState({ ristorante: response.data });
    })
    axios.post("http://localhost:8888/select_prenotazioni_inattesa.php ", ricerca_ristorante[0]).then(response => {
      this.setState({ inattesa: response.data });
    })
    axios.post("http://localhost:8888/select_prenotazioni_accettate.php ", ricerca_ristorante[0]).then(response => {
      this.setState({ accettate: response.data });
    })
    axios.post("http://localhost:8888/select_prenotazioni_rifiutate.php ", ricerca_ristorante[0]).then(response => {
      this.setState({ rifiutate: response.data });
    })
  }

  handlePrenotazione = (stato, id) => (event) => {
    event.preventDefault();
    const prenotazione = this.state.inattesa[id].ID_prenotazione;
    const aggiorna = [
      {
        id_prenotazione: prenotazione,
        stato: stato,
      }
    ]
    axios.post("http://localhost:8888/aggiorna_stato_prenotazione.php ", aggiorna[0]);
    if (stato === 1) {
      this.state.accettate.push(this.state.inattesa[id]);
      this.state.accettate.sort((a, b) => a.Data_prenotazione < b.Data_prenotazione ? -1 : 1);
    }
    else {
      this.state.rifiutate.push(this.state.inattesa[id]);
      this.state.rifiutate.sort((a, b) => a.Data_prenotazione < b.Data_prenotazione ? -1 : 1);
    }
    this.setState({ inattesa: this.state.inattesa.filter(inattesa => inattesa.ID_prenotazione !== prenotazione) });
  }

  handleRipristinaAccettate = (id) => (event) => {
    event.preventDefault();
    const prenotazione = this.state.accettate[id].ID_prenotazione;
    const aggiorna = [
      {
        id_prenotazione: prenotazione,
        stato: 3,
      }
    ]
    axios.post("http://localhost:8888/aggiorna_stato_prenotazione.php ", aggiorna[0]);
    this.state.inattesa.push(this.state.accettate[id]);
    this.setState({ accettate: this.state.accettate.filter(accettate => accettate.ID_prenotazione !== prenotazione) });
    this.state.inattesa.sort((a, b) => a.Data_prenotazione < b.Data_prenotazione ? -1 : 1);
  }

  handleRipristinaRifiutate = (id) => (event) => {
    event.preventDefault();
    const prenotazione = this.state.rifiutate[id].ID_prenotazione;
    const aggiorna = [
      {
        id_prenotazione: prenotazione,
        stato: 3,
      }
    ]
    axios.post("http://localhost:8888/aggiorna_stato_prenotazione.php ", aggiorna[0]);
    this.state.inattesa.push(this.state.rifiutate[id]);
    this.setState({ rifiutate: this.state.rifiutate.filter(rifiutate => rifiutate.ID_prenotazione !== prenotazione) });
    this.state.inattesa.sort((a, b) => a.Data_prenotazione < b.Data_prenotazione ? -1 : 1);
  }

  render() {
    return (
      <>
      <Navbar key="navbar-key" />
      <div className="container-fluid p-auto border width-95 rounded border-2 margin-tb h-auto">
        <h1 className="my-5 d-flex justify-content-center">LISTA PRENOTAZIONI RISTORANTE: 
        {this.state.ristorante && this.state.ristorante.map((rs, index) => (
          <div className="mx-3" key={index}>{rs.Ragione_sociale}</div>
          ))} 
        </h1>
          <div className="row mb-5 mx-3">
            <h3 className="attive text-center mb-4">In attesa</h3>
            <table className="table-attive table">
              <thead className="thead-dark">
                <tr>
                  <th>Prenotazione</th>
                  <th>Cliente</th>
                  <th>N. persone</th>
                  <th>Giorno</th>
                  <th>Orario</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                {this.state.inattesa.length !== 0 && this.state.inattesa.map((rs, index) => (
                  <tr key={index} >
                    <td>{rs.ID_prenotazione}</td>
                    <td>{rs.Username}</td>
                    <td>{rs.Num_persone}</td>
                    <td>{rs.Data_prenotazione}</td>
                    <td>{rs.Orario_arrivo} - {rs.Orario_partenza}</td>
                    <td>
                      <div className="form-group">
                        <button type="button" className="btn btn-outline-success btn-sm mx-2" onClick={this.handlePrenotazione(1, index)}>Accetta</button>
                        <button type="button" className="btn btn-outline-danger btn-sm mx-2" onClick={this.handlePrenotazione(0, index)}>Rifiuta</button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
          <div className="row mb-5 mx-3">
          <div className="col-6">
            <h3 className="scadute text-center mb-4">Accettate</h3>
            <table className="table-scadute table">
              <thead>
                <tr>
                  <th>Prenotazione</th>
                  <th>Cliente</th>
                  <th>N. persone</th>
                  <th>Giorno</th>
                  <th>Orario</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                {this.state.accettate.length !== 0 && this.state.accettate.map((rs, index) => (
                  <tr key={index} >
                    <td>{rs.ID_prenotazione}</td>
                    <td>{rs.Username}</td>
                    <td>{rs.Num_persone}</td>
                    <td>{rs.Data_prenotazione}</td>
                    <td>{rs.Orario_arrivo} - {rs.Orario_partenza}</td>
                    <td>
                      <div className="form-group col-1">
                        <button type="button" className="btn btn-outline-primary btn-sm" onClick={this.handleRipristinaAccettate(index)}>Ripristina</button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
          <div className="col-6">
            <h3 className="rifiutate text-center mb-4">Rifiutate</h3>
            <table className="table-rifiutate table">
              <thead>
                <tr>
                  <th>Prenotazione</th>
                  <th>Cliente</th>
                  <th>N. persone</th>
                  <th>Giorno</th>
                  <th>Orario</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                {this.state.rifiutate.length !== 0 && this.state.rifiutate.map((rs, index) => (
                  <tr key={index} >
                    <td>{rs.ID_prenotazione}</td>
                    <td>{rs.Username}</td>
                    <td>{rs.Num_persone}</td>
                    <td>{rs.Data_prenotazione}</td>
                    <td>{rs.Orario_arrivo} - {rs.Orario_partenza}</td>
                    <td>
                      <div className="form-group col-1" onClick={this.handleRipristinaRifiutate(index)}>
                        <button type="button" className="btn btn-outline-primary btn-sm">Ripristina</button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
        </div>
      </>
    )
  }
}

export default DashboardRistoratori