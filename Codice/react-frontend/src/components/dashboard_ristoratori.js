import React, { Component } from "react";
import axios from 'axios';
import { Navigate } from "react-router-dom";
import "../App.css";

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
    axios.post("http://localhost:8888/select_ristorante.php ", ricerca_ristorante[0], { headers: { 'Content-Type': 'application/json' } }).then(response => {
      this.setState({ ristorante: response.data });
    })
    axios.post("http://localhost:8888/select_prenotazioni_inattesa.php ", ricerca_ristorante[0], { headers: { 'Content-Type': 'application/json' } }).then(response => {
      this.setState({ inattesa: response.data });
    })
    axios.post("http://localhost:8888/select_prenotazioni_accettate.php ", ricerca_ristorante[0], { headers: { 'Content-Type': 'application/json' } }).then(response => {
      this.setState({ accettate: response.data });
    })
    axios.post("http://localhost:8888/select_prenotazioni_rifiutate.php ", ricerca_ristorante[0], { headers: { 'Content-Type': 'application/json' } }).then(response => {
      this.setState({ rifiutate: response.data });
    })
  }

  handleBack = () => (event) => {
    this.setState({ submittedBack: true });
  }

  getColor = (stato) => {
    if (stato === 0) return 'red';
    if (stato === 1) return 'green';
    return 'white';
  };

  getColorHeader = () => {
    return 'gray';
  };

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
      <div>
        {this.state.submittedBack && (
          <Navigate to="/login"
          />)}
        <br></br>
        <h1 className="my-5 d-flex justify-content-center">Lista prenotazioni ristorante: {this.state.ristorante.map((rs, index) => (<div key={index}>{rs.Ragione_sociale}</div>))} </h1>
        <div>
          <button onClick={this.handleBack()} type="button" className="btn-partecipanti btn btn-outline-primary back">Back</button>
        </div>
        <h3 className="attive">In attesa</h3>
        <h3 className="scadute">Accettate</h3>
        <table className="table-attive">
          <thead>
            <tr style={{ background: this.getColorHeader() }} >
              <th>Prenotazione</th>
              <th>Cliente</th>
              <th>N. persone</th>
              <th>Giorno</th>
              <th>Orario</th>
              <th></th>
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
                  <div className="form-group col-1" onClick={this.handlePrenotazione(1, index)}>
                    <button type="button" className="btn btn-outline-success btn-sm">Accetta</button>
                  </div>
                </td>
                <td>
                  <div className="form-group col-1" onClick={this.handlePrenotazione(0, index)}>
                    <button type="button" className="btn btn-outline-danger btn-sm">Rifiuta</button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        <table className="table-scadute">
          <thead>
            <tr style={{ background: this.getColorHeader() }} >
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
                  <div className="form-group col-1" onClick={this.handleRipristinaAccettate(index)}>
                    <button type="button" className="btn btn-outline-primary btn-sm">Ripristina</button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
        <h3 className="rifiutate">Rifiutate</h3>
        <table className="table-rifiutate">
          <thead>
            <tr style={{ background: this.getColorHeader() }} >
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
    )
  }
}

export default DashboardRistoratori