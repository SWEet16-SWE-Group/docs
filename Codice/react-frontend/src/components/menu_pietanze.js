import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import axios from 'axios';

import Navbar from './navbar';

class MenuPietanze extends Component {
  constructor(props) {
    super(props);
    this.state = {
      prenotazione: [],
      pietanze: [],
    };
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  componentDidMount() {
    let id_cliente = -1;
    let utente = "";
    if (localStorage && localStorage.getItem('idc')) { id_cliente = JSON.parse(localStorage.getItem('idc')) }
    if (localStorage && localStorage.getItem('idu')) { utente = JSON.parse(localStorage.getItem('idu')) }
    const ricerca_ristorante = [
      {
        id_cliente: id_cliente,
        username: utente,
      }
    ]

    axios.post("http://localhost:8888/select_prenotazione_utente.php ", ricerca_ristorante[0]).then(response =>
      this.setState({ prenotazione: response.data }, () => {
        let id_ristorante = this.state.prenotazione[0].Id_ristorante;
        axios.post('http://localhost:8888/select_multiple_prodotto.php', { id_ristorante }).then(response => {
          this.setState({ pietanze: response.data });
        })
      }))
  }

  handleSubmit = (event) => {

    event.preventDefault();

    const cliente = this.state.clienteselezionato[0].ID_cliente;
    const tavolo = this.state.tavoloselezionato[0].ID_tavolo;
    const ristorante = this.state.ristoranteselezionato[0].ID_ristorante;
    const numero = this.state.partecipanti.length + 1;
    const username = this.state.clienteselezionato[0].Username;
    const codice = username + "#" + tavolo;
    const data = this.state.data;
    const inizio = this.state.orarioarrivo;
    const fine = this.state.orariopartenza;
    const cod_tavolo = this.state.tavoloselezionato[0].Codice;
    const posti_tavolo = this.state.tavoloselezionato[0].Num_posti;
    const invitati = username + ', ' + this.state.partecipanti.join(', ')

    const insert = [
      {
        id_cliente: cliente,
        id_tavolo: tavolo,
        id_ristorante: ristorante,
        codice_prenotazione: codice,
        numero_persone: numero,
        partecipanti: invitati,
        giorno: data,
        arrivo: inizio,
        partenza: fine,
        codice: cod_tavolo,
        posti: posti_tavolo,
      }
    ]

    axios
      .post("http://localhost:8888/insert_prenotazione.php", insert[0]).then(response => {
        this.setState({ prenotazione: response.data, form: false, completo: true });
      })
  };

  render() {

    return (
        
      <>
        <Navbar key="navbar-key" />
        <div className="container-fluid p-auto width-95 margin-tb h-auto">
          <form className="row gx-0 d-flex justify-content-center" onSubmit={this.handleSubmit}>
            {this.state.pietanze.map((rs, index) => (
            <div key={index} className="card m-5 col-lg-3 col-sm-6">
                <img className="card-img-top h-50" src ={`data:image/jpeg;base64,${rs.Immagine}`} alt={rs.Nome_Immagine}/>
              <div className="card-body text-center">
                <h5 className="card-title">{rs.Nome}</h5>
                <p className="card-text">{rs.Descrizione}</p>
                <div className="row justify-content-center mb-3">
                  <input type="number" className="form-control w-25 text-center" name={"quantita" + rs.Nome} id={"quantita" + rs.Nome} min="1" defaultValue="1"/>
                </div>
                <h6 className="card-text">€{rs.Prezzo}</h6>
              </div>
                <Link to={`/dettagli/${rs.ID_prodotto}`} className="btn btn-outline-primary btn-outline btn-lg m-2">DETTAGLI</Link>
                <button type="submit" className="btn btn-primary btn-lg m-2">AGGIUNGI</button>
            </div>
            ))}
          </form>
        </div>
      </>

    );
          
  }
}

export default MenuPietanze;