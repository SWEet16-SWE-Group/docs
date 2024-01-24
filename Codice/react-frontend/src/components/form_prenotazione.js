import React, { Component } from 'react';
import axios from 'axios';

import Navbar from './navbar';

class FormPrenotazione extends Component {
  constructor(props) {
    super(props);
    this.state = {
      prenotazione: [],
      altriclienti: [],
      partecipanti: [],
      clienteselezionato: [],
      ristoranti: [],
      ristoranteselezionato: [],
      tavoloselezionato: [],
      postidisponibili: "",
      data: "",
      orarioarrivo: "",
      orariopartenza: "",
      form: true,
      completo: false
    };
    this.handleRadioChange = this.handleRadioChange.bind(this);
    this.handleDateChange = this.handleDateChange.bind(this);
    this.handleTimeAChange = this.handleTimeAChange.bind(this);
    this.handleTimePChange = this.handleTimePChange.bind(this);
    this.handleCheckboxChange = this.handleCheckboxChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  componentDidMount() {
    let id_cliente = -1;
    let utente = "";
    if (localStorage && localStorage.getItem('idc')) { id_cliente = JSON.parse(localStorage.getItem('idc')) }
    if (localStorage && localStorage.getItem('idu')) { utente = JSON.parse(localStorage.getItem('idu')) }
    this.setState({ id_cliente: id_cliente });
    this.setState({ utente: utente });
    const ricerca_cliente = [
      {
        id_cliente: id_cliente,
        utente: utente,
      }
    ]

    axios.post("http://localhost:8888/select_cliente.php ", ricerca_cliente[0]).then(response =>
      this.setState({ clienteselezionato: response.data }, () => {
        let id_cliente = this.state.clienteselezionato[0].ID_cliente;
        axios.post('http://localhost:8888/select_multiple_exeption_cliente.php', { id_cliente }).then(response => {
          this.setState({ altriclienti: response.data });
        })
      }))

    axios.get('http://localhost:8888/select_multiple_ristorante.php').then(response =>
      this.setState({ ristoranti: response.data }));

  }

  handleRadioChange = (event) => {
    let id = event.target.value;
    const nuovoRistoranteSelezionato = [this.state.ristoranti[id]];
    const id_ristorante = nuovoRistoranteSelezionato[0].ID_ristorante;

    this.setState({ ristoranteselezionato: nuovoRistoranteSelezionato, }, () => {
      axios
        .post("http://localhost:8888/select_limit_single_tavolo.php", { id_ristorante }).then(response => {
          const tavolo = response.data;
          if (this.state.partecipanti.length !== 0) {
            let numeropartecipanti = this.state.partecipanti.length;
            this.setState({ tavoloselezionato: tavolo, postidisponibili: tavolo[0].Num_posti - numeropartecipanti - 1 });
          }
          else {
            this.setState({ tavoloselezionato: response.data, postidisponibili: tavolo[0].Num_posti - 1 });
          }
        })
    });
  }

  handleCheckboxChange = (event) => {
    const nome = event.target.value;
    const { partecipanti } = this.state;

    if (partecipanti.includes(nome)) {
      let numero = this.state.postidisponibili + 1;
      this.setState({ postidisponibili: numero, partecipanti: partecipanti.filter((username) => username !== nome) });
    } else {
      let numero = this.state.postidisponibili - 1;
      this.setState({ postidisponibili: numero, partecipanti: [...partecipanti, nome] });
    }
  };
  
  handleDateChange = (event) => {
    this.setState({ data: event.target.value });

  }

  handleTimeAChange = (event) => {
    this.setState({ orarioarrivo: event.target.value });
  }

  handleTimePChange = (event) => {
    this.setState({ orariopartenza: event.target.value });
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
        {this.state.form && (
          <form id="form-prenotazione" className="container-fluid p-auto w-75 border rounded border-2 margin-tb h-auto" onSubmit={this.handleSubmit}>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
            <div className="row mx-auto justify-content-between">
              <div className="m-5 col-4">
                <label htmlFor="ricerca">Seleziona un ristorante:</label>
                {this.state.ristoranti && this.state.ristoranti.map((rs, index) => (
                  <div key={index}>
                    <input type="radio" className="form-check-input mb-2 mr-1" id="seleziona_rist" name="seleziona_rist" value={index} onClick={this.handleRadioChange} /> <label htmlFor="seleziona_rist" className="text-break">{rs.Ragione_sociale + ", " + rs.Citta}</label>
                  </div>
                ))}
              </div>
              <div className="m-5 col-4">
                <label htmlFor="ricerca_cliente">Invita un utente:</label>
                {this.state.altriclienti && this.state.altriclienti.map((rs, index) => (
                  <div key={index}>
                    <input type="checkbox" className="form-check-input mb-2 mr-1" id="invita_utenti" name="invita_utenti" value={rs.Username} disabled={this.state.ristoranteselezionato.length === 0 || (this.state.postidisponibili === 0 && !this.state.partecipanti.includes(rs.Username))} onChange={this.handleCheckboxChange} /> <label htmlFor="invita_utenti" className="text-break">{rs.Username}</label>
                  </div>
                ))}
                <div className="mt-1">
                  <span>Numero posti disponibili: {this.state.postidisponibili}</span>
                </div>
              </div>
            </div>
            <div className="row mx-auto justify-content-between">
              <div className="m-5 col-4">
                <label htmlFor="data_prenotazione">Seleziona il giorno:</label>
                <input type="date" className="form-control" name="data_prenotazione" id="data_prenotazione" onChange={this.handleDateChange} />
              </div>
              <div className="m-5 col-4">
                <label htmlFor="orario_arrivo">Seleziona l'orario di arrivo:</label>
                <input type="time" className="form-control" name="orario_arrivo" id="orario_arrivo" onChange={this.handleTimeAChange} />
                <label htmlFor="data_prenotazione">Seleziona l'orario di partenza:</label>
                <input type="time" className="form-control" name="orario_arrivo" id="orario_arrivo" onChange={this.handleTimePChange} />
              </div>
            </div>
            {this.state.tavoloselezionato[0] && this.state.tavoloselezionato[0] && this.state.data && this.state.orarioarrivo && this.state.orariopartenza && this.state.postidisponibili >= 0 && (
              <div className="container-fluid my-4 text-center">
                <hr />
                <h3 className="my-4">Riepilogo prenotazione</h3>
                {this.state.ristoranteselezionato && this.state.ristoranteselezionato.map((rs, index) => (
                  <h5 key={index} className="my-2">Ristorante: {rs.Ragione_sociale}, {rs.Indirizzo}, {rs.CAP} {rs.Citta} </h5>
                ))}
                <h5 className="my-3">Data: {this.state.data}</h5>
                <h5 className="my-3">Orari: {this.state.orarioarrivo} - {this.state.orariopartenza}</h5>
                <h5 className="my-3">Numero di persone: {this.state.partecipanti.length + 1}</h5>
                <h5 className="my-3">Partecipanti: {this.state.clienteselezionato[0].Username + "," + this.state.partecipanti}</h5>
                <h5 className="my-2">Codice tavolo: {this.state.tavoloselezionato[0].Codice}</h5>
                <button type="submit" className="btn btn-primary btn-lg w-100 mt-3">PRENOTA</button>
              </div>
            )}
          </form>
        )}

        {this.state.completo && (
          <div id="form-invito">
            <div className="container-fluid p-auto w-75 border rounded border-2 margin-tb h-auto">
              <h1 className="my-4 text-center text-success">PRENOTAZIONE EFFETTUATA CON SUCCESSO</h1>
              {this.state.prenotazione && this.state.prenotazione.map((rs, index) => (
                <h5 key={index} className="my-5 text-center">Il tuo codice di prenotazione è: {rs.Codice}</h5>
              ))}
            </div>
          </div>
        )}
      </>
    );
  }
}

export default FormPrenotazione;