import React, { Component } from 'react';
import { Navigate } from "react-router-dom";
import axios from 'axios';

class ListaPrenotazioni extends Component {
  constructor(props) {
    super(props);
    this.state = {
      prenotazioni: [],
      ristorante: [],
      cliente: [],
      submittedPartecipanti: false,
    };
  }

  UNSAFE_componentWillMount() {
    let id_cliente = -1;
    if (localStorage && localStorage.getItem('idc')) {
        id_cliente = JSON.parse(localStorage.getItem('idc'))
    }
    this.setState({id_cliente: id_cliente});

    this.setState({id_cliente: 1});
    const ricerca_cliente = [
      {
      id_cliente : id_cliente,
      }
    ]

    axios.post("http://localhost:8888/select_single_cliente.php ", ricerca_cliente[0], {headers: { 'Content-Type': 'application/json' }}).then(response => {
      this.setState({cliente: response.data});
    })

    axios.post("http://localhost:8888/select_prenotazioni_cliente.php ", ricerca_cliente[0], {headers: { 'Content-Type': 'application/json' }}).then(response => {
      this.setState({prenotazioni: response.data});
    })
  }

  handleModifica = (id) => (event) => {}

  handleOrdinazione = (id) => (event) => {
    event.preventDefault();
    this.setState({submittedOrdinazione: true});
    localStorage.setItem('idp', this.state.prenotazioni[id].ID_prenotazione);
  }

  handlePartecipanti = (id) => (event) => {
    //event.preventDefault();
    //this.setState({submittedPartecipanti: true});
    //localStorage.setItem('idp', this.state.prenotazioni[id].ID_prenotazione);
}

render() {
    return (
      <div>
        {this.state.submittedPartecipanti && (
        <Navigate to="/partecipanti"
        />)}
        {this.state.submittedOrdinazione && (
        <Navigate to="/ordinazione"
        />)}

      <form>
            <h1 className="my-4 d-flex justify-content-center">Lista prenotazioni cliente: {this.state.cliente.map((rs, index) => (<div key={index}>{rs.Username}</div>))} </h1>
            <div>
              <button onClick={this.handleOrdinazione}  type="button" className="btn-partecipanti btn btn-outline-primary">Tutte</button>
              <button onClick={this.handleOrdinazione} type="button" className="btn-partecipanti btn btn-outline-primary">Attive</button>
            <button onClick={this.handleOrdinazione} type="button" className="btn-partecipanti btn btn-outline-primary">Non Attive</button>
            </div>
            <p></p>
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
                 {this.state.prenotazioni.length !== 0 && this.state.prenotazioni.map((rs, index) => (
                 <tr key={index}>
                   <td>{rs.Ragione_sociale}</td>
                   <td>{rs.Codice}</td>
                   <td>{rs.Num_persone}</td>
                   <td>{rs.Orario_inizio} - {rs.Orario_fine}</td>
{/*
                   <td>
                    <div className="form-group col-1" onSubmit={this.handleModifica(index)}>
                        <button type="submit" className="btn btn-outline-primary">Modifica</button>
                    </div>
                    </td>
*/}
                    <td>
                    <div className="form-group col-1" onClick={this.handleOrdinazione(index)}>
                        <button type="button" className="btn btn-outline-primary">Ordinazione</button>
                    </div>
                    </td>
{/*
                    <td>
                    <div className="form-group col-1" onClick={this.handlePartecipanti(index)}>
                        <button type="button" className="btn btn-outline-primary">Partecipanti</button>
                    </div>
                    </td>
*/}
                 </tr>
                 ))}
               </tbody>
             </table>
        </form>
        </div>
      );
    }
}
    
export default ListaPrenotazioni;