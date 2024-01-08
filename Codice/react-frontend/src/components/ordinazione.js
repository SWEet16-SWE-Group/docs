import React, { Component } from 'react';
import { Navigate } from "react-router-dom";
import axios from 'axios';

class Partecipanti extends Component {
  constructor(props) {
    super(props);
    this.state = {
      partecipanti: [],
      prenotazione: [],
      ordinazione: [],
      submittedPartecipanti: false,
    };
 }

  UNSAFE_componentWillMount() {
    let id_prenotazione = -1;
    if (localStorage && localStorage.getItem('idp')) {
        id_prenotazione = JSON.parse(localStorage.getItem('idp'))
    }
    this.setState({id_prenotazione: id_prenotazione});
    const ricerca_prenotazione = [
      {
      id_prenotazione : id_prenotazione,
      }
    ]
    axios.post("http://localhost:8888/select_prenotazione.php ", ricerca_prenotazione[0], {headers: { 'Content-Type': 'application/json' }}).then(response => {
      this.setState({prenotazione: response.data});
    })

    axios.post("http://localhost:8888/select_ordinazioni.php ", ricerca_prenotazione[0], {headers: { 'Content-Type': 'application/json' }}).then(response => {
      this.setState({ordinazione: response.data});
    })

//    axios.post("http://localhost:8888/select_partecipanti_prenotazione.php ", ricerca_prenotazione[0], {headers: { 'Content-Type': 'application/json' }}).then(response => {
//      this.setState({partecipanti: response.data});
//    })
  }

  handleAggiuntaPiatto = (event) => {
    event.preventDefault();
    //this.setState({submittedPartecipanti: true});
  }

  handleAnnulla = (event) => {
    event.preventDefault();
    this.setState({submittedPartecipanti: true});
  }

  handleConferma = (id) => (event) => {
    event.preventDefault();
    this.setState({submittedPartecipanti: true});

  }

  render() {
    return (
      <div>
        {this.state.submittedPartecipanti && (
       <Navigate to="/listaprenotazioni"
       // state={// you can pass state/props here}
      />)}
      <form className="my-3">
            <h1 className="my-4 d-flex justify-content-center">Ordinazione: </h1>
            <table className="table table-striped">
              <thead className="thead-light">
                <tr>
                 <th>Ristorante</th>
                 <th>Tavolo</th>
                 <th>Numero posti</th>
                 <th>Giorno</th>
                </tr>
               </thead>
               <tbody>
                 {this.state.prenotazione.length !== 0 && this.state.prenotazione.map((rs, index) => (
                 <tr key={index}>
                   <td>{rs.Ragione_sociale}</td>
                   <td>{rs.Codice}</td>
                   <td>{rs.Num_persone}</td>
                   <td>{rs.Orario_inizio} - {rs.Orario_fine}</td>
                 </tr>
                 ))}
              </tbody>
            </table>
            <h2>Elenco piatti scelti</h2>
            <table className="table table-striped">
              <thead className="thead-light">
                <tr>
                 <th>Descizione</th>
                 <th>Quantità</th>
                 <th>Prezzo</th>
                 <th>Allergeni</th>
                </tr>
               </thead>
            {this.state.ordinazione.length !== 0 && this.state.ordinazione.map((rs, index) => (
                 <tr key={index}>
                 <td>{rs.Descrizione}</td>
                 <td>{rs.Quantita}</td>
                 <td>{rs.Prezzo}</td>
                 <td>{rs.Allergeni}</td>
                 <td>
                  <div className="form-group col-1" onClick={this.handleOrdinazione(index)}>
                      <button type="button" className="btn btn-outline-primary">Ordinazione</button>
                  </div>
                  </td>
               </tr>
          ))}
            </table>
            <button onClick={this.handleAggiuntaPiatto}  type="button" className="btn-partecipanti btn btn-outline-primary">Aggiunta Piatto</button>
            <p> </p>
            <div>
              <button onClick={this.handleAnnulla}  type="button" className="btn-partecipanti btn btn-outline-primary">Annulla</button>
              <button onClick={this.handleConferma()} type="button" className="btn-partecipanti btn btn-outline-primary">Conferma</button>
            </div>
          </form>
        </div>
      );
      }
}

export default Partecipanti;