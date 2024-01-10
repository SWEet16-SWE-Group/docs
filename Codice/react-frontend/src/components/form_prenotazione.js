import React, { Component } from 'react';
import axios from 'axios';

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
      tavoli: [],
      tavoloselezionato: [],
      numeropersone: "",
      data: "",
      orarioarrivo: "",
      orariopartenza: "",
      form: true,
      completo: false
    };
    this.handleRadioChange = this.handleRadioChange.bind(this);
    this.handleNumberChange = this.handleNumberChange.bind(this);
    this.handleDateChange = this.handleDateChange.bind(this);
    this.handleTimeAChange = this.handleTimeAChange.bind(this);
    this.handleTimePChange = this.handleTimePChange.bind(this);
    this.handleCheckboxChange = this.handleCheckboxChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  componentDidMount() {
    axios.get('http://localhost:8888/select_multiple_ristorante.php').then(response =>
      this.setState({ ristoranti: response.data}));

    axios.get('http://localhost:8888/select_single_cliente.php').then(response =>
      this.setState({ clienteselezionato: response.data}, () => {

        let id_cliente=this.state.clienteselezionato[0].ID_cliente;
        axios.post('http://localhost:8888/select_multiple_exeption_cliente.php', {id_cliente}).then(response =>
        {        
          this.setState({ altriclienti: response.data});
        }) 

      }));

  }

  componentSendData(){
    if((this.state.numeropersone !== "") && (this.state.ristoranteselezionato[0].ID_ristorante !== ""))
    {
    const tavolo = [
      {
      id_ristorante : this.state.ristoranteselezionato[0].ID_ristorante,
      num_posti : this.state.numeropersone,
      } 
    ]

     axios
      .post("http://localhost:8888/select_limit_multiple_tavolo.php", tavolo[0]).then(response => 
      {
        this.setState({ tavoloselezionato: response.data});
      }) 
    }

  }

  handleRadioChange = (event) => { 
    let id = event.target.value;
    const nuovoRistoranteSelezionato = [this.state.ristoranti[id]];

    this.setState({ristoranteselezionato: nuovoRistoranteSelezionato,});
  }

  handleCheckboxChange = (event) => {
    const nome = event.target.value;
    const { partecipanti } = this.state;
  
    if (partecipanti.includes(nome)) 
    {
      this.setState({partecipanti: partecipanti.filter((username) => username !== nome),});
    } 
    else 
    {
      this.setState({partecipanti: [...partecipanti, nome],});
    }
  };

  handleDateChange = (event) => { 
    this.setState({data: event.target.value });

  }

  handleTimeAChange = (event) => { 
    this.setState({orarioarrivo: event.target.value });
  }

  handleTimePChange = (event) => { 
    this.setState({orariopartenza: event.target.value });
  }

  handleNumberChange = (event) => {
    this.setState({numeropersone: event.target.value}, () => {
      this.componentSendData();
      console.log(this.state);
    });
  }

  handleSubmit = (event) => {

    event.preventDefault();

    const cliente = this.state.clienteselezionato[0].ID_cliente;
    const tavolo = this.state.tavoloselezionato[0].ID_tavolo;
    const ristorante = this.state.ristoranteselezionato[0].ID_ristorante;
    const numero = this.state.numeropersone;
    const username = this.state.clienteselezionato[0].Username;
    const codice = username + "#" + tavolo;
    const data = this.state.data;
    const inizio = this.state.orarioarrivo;
    const fine = this.state.orariopartenza;
    const cod_tavolo = this.state.tavoloselezionato[0].Codice;
    const posti_tavolo = this.state.tavoloselezionato[0].Num_posti;
    const invitati = username + ',' + this.state.partecipanti.join(', ')

    const insert = [
      {
      id_cliente : cliente,
      id_tavolo : tavolo,
      id_ristorante : ristorante,
      codice_prenotazione: codice,
      numero_persone : numero,
      partecipanti : invitati,
      giorno : data,
      arrivo: inizio,
      partenza: fine,
      codice: cod_tavolo,
      posti: posti_tavolo,
      }
    ]

    axios
      .post("http://localhost:8888/insert_prenotazione.php", insert[0]).then(response => 
      {
        this.setState({ prenotazione: response.data, form: false, completo: true});
      })
  };

  render() {

    return (
        <>
        {this.state.form && (
        <form id="form-prenotazione" className="container-fluid p-auto w-75 border rounded border-2 margin-tb h-auto" onSubmit={this.handleSubmit}>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
            <div className="row mx-auto justify-content-between">
              <div className="m-5 col-4">
                  <label htmlFor="ricerca">Seleziona un ristorante:</label>
                  {this.state.ristoranti.map((rs, index) => (
                      <div key={index}>
                          <input type="radio" className="form-check-input mb-2 mr-1" id="seleziona_rist" name="seleziona_rist" value={index} onClick={this.handleRadioChange}/> <label htmlFor="seleziona_rist" className="text-break">{rs.Ragione_sociale + ", " + rs.Citta}</label>
                      </div>
                  ))}
              </div>
              <div className="m-5 col-4">
              <label htmlFor="ricerca_cliente">Invita un altro utente:</label>
              {this.state.altriclienti.map((rs, index) => (
                <div key={index}>
                    <input type="checkbox" className="form-check-input mb-2 mr-1" id="invita_utenti" name="invita_utenti" value={rs.Username} onClick={this.handleCheckboxChange}/> <label htmlFor="invita_utenti" className="text-break">{rs.Username}</label>
                </div>
              ))}
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
            <div className="m-5">
                <label htmlFor="num_persone">Seleziona il numero di persone:</label>
                <input type="number" className="form-control" name="num_persone" id="num_persone" min="1" onChange={this.handleNumberChange} />
            </div>
            {this.state.tavoloselezionato[0] && this.state.data && this.state.orarioarrivo && this.state.orariopartenza && this.state.numeropersone && (
            <div className="container-fluid my-4 text-center">
                  <h3 className="my-4">Informazioni prenotazione</h3>
                  {this.state.ristoranteselezionato.map((rs, index) => (
                  <h5 key={index} className="my-2">Ristorante: {rs.Ragione_sociale}, {rs.Indirizzo}, {rs.CAP} {rs.Citta} </h5>
                  ))}
                  <h5 className="my-3">Data: {this.state.data}</h5>
                  <h5 className="my-3">Orari: {this.state.orarioarrivo} - {this.state.orariopartenza}</h5>
                  <h5 className="my-3">Numero di persone: {this.state.numeropersone}</h5>
                  {this.state.tavoloselezionato.map((rs, index) => (
                  <h5 key={index} className="my-2">Codice tavolo: {rs.Codice}</h5>
                  ))}
                  <button type="submit" className="btn btn-primary btn-lg w-100 mt-3">PRENOTA</button>
            </div>
            )}
        </form>
        )}

      {this.state.completo && (
        <div id="form-invito">
           <div className="container-fluid p-auto w-75 border rounded border-2 margin-tb h-auto">
           <h1 className="my-4 text-center text-success">PRENOTAZIONE EFFETTUATA CON SUCCESSO</h1>
           {this.state.prenotazione.map((rs, index) => (
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