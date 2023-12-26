import React, { Component } from 'react';
import { Carousel } from 'react-bootstrap';
import axios from 'axios';

class FormPrenotazione extends Component {
  constructor(props) {
    super(props);
    this.state = {
      ristoranti: [],
      ristorantifiltrati: [],
      ristoranteselezionato: [],
      tavoli: [],
      cerca: "",
      numeropersone: "",
      data: "",
      orarioarrivo: "",
      orariopartenza: "",
      page: 0,
      page0compiled: false,
      page1compiled: false,
      page2compiled: false,
    };
    this.filterList = this.filterList.bind(this);
    this.handleSearch = this.handleSearch.bind(this);
    this.handleRadioChange = this.handleRadioChange.bind(this);
    this.handleNumberChange = this.handleNumberChange.bind(this);
    this.handleDateChange = this.handleDateChange.bind(this);
    this.handleTimeAChange = this.handleTimeAChange.bind(this);
    this.handleTimePChange = this.handleTimePChange.bind(this);
  }

  componentDidMount() {
    axios.get('http://localhost:8888/select_multiple_ristorante.php').then(response =>
      this.setState({ ristoranti: response.data}));
  }

  componentDidMount2() {
    axios.get('http://localhost:8888/select_multiple_ristorante.php').then(response =>
      this.setState({ ristoranti: response.data}));
  }

  handleSelect = (selectedPage) => {
    this.setState({ page: selectedPage });
  };

  handleSearch = (event) => {
    const cerca = event.target.value.toLowerCase();
    this.setState({ cerca }, () => this.filterList());
  }

  filterList() {
    let ristoranti = this.state.ristoranti;
    let cerca = this.state.cerca;

    ristoranti = ristoranti.filter(function(ristoranti) {
      return ristoranti.Ragione_sociale.toLowerCase().indexOf(cerca) !== -1;
    });
    this.setState({ ristorantifiltrati: ristoranti });
  }

  handleRadioChange = (event) => { 
    let id = event.target.value;
    this.state.ristoranteselezionato[0] = this.state.ristoranti[id];
    this.state.page0compiled = true;
    document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
  }

  handleDateChange = (event) => { 
    let data = event.target.value;
    this.state.data = data;
    if((this.state.orariopartenza !== "") && ( this.state.orarioarrivo !== ""))
    {
      this.state.page1compiled=true;
      document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
    }
    if(data==="")
    {
      this.state.page1compiled=false;
      document.getElementsByClassName("carousel-control-next")[0].style.display="none";
    }
  }

  handleTimeAChange = (event) => { 
    let oraa = event.target.value;
    this.state.orarioarrivo = oraa;
    if((this.state.orariopartenza !== "") && ( this.state.data !== ""))
    {
      this.state.page1compiled=true;
      document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
    }
    if(oraa==="")
    {
      this.state.page1compiled=false;
      document.getElementsByClassName("carousel-control-next")[0].style.display="none";
    }
  }

  handleTimePChange = (event) => { 
    let orap = event.target.value;
    this.state.orariopartenza = orap;
    if((this.state.orarioarrivo !== "") && ( this.state.data !== ""))
    {
      this.state.page1compiled=true;
      document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
    }
    if(orap==="")
    {
      this.state.page1compiled=false;
      document.getElementsByClassName("carousel-control-next")[0].style.display="none";
    }
  }

  handleNumberChange = (event) => {
    let num = event.target.value;
    if(num==="")
    {
      document.getElementsByClassName("carousel-control-next")[0].style.display="none";
      this.state.page2compiled = false;
    }
    else
    {
    this.state.numeropersone = num;
    document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
    this.state.page2compiled = true;
    
    const id =  this.state.ristoranteselezionato[0].ID_Ristorante;
    const data =  this.state.data;
    const oraa =  this.state.orarioarrivo;
    const orap =  this.state.orariopartenza;

    const tavolo = [
      {
      id_ristorante : id,
      num_posti : num,
      giorno : data,
      orario_arrivo: oraa,
      orario_partenza: orap
      } 
    ]
    event.preventDefault();

    axios
      .post("http://localhost:8888/select_multiple_tavolo.php", tavolo[0])

    axios
      .get('http://localhost:8888/select_multiple_tavolo.php').then(response =>
      this.setState({ tavoli: response.data}));

      console.log(this.state.tavoli);

    }
  }

  render() {
    const { page } = this.state;
      if(document.getElementsByClassName("carousel-control-prev")[0] && document.getElementsByClassName("carousel-control-next")[0])
      {
        if(page === 0 && this.state.page0compiled === false)
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="none";
          document.getElementsByClassName("carousel-control-next")[0].style.display="none";
        }
        else if(page === 0 && this.state.page0compiled === true) 
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="none";
          document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
        }
        else if((page === 1 && this.state.page1compiled === false) || (page === 2 && this.state.page2compiled === false))
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="flex";
          document.getElementsByClassName("carousel-control-next")[0].style.display="none";
        }
        else if((page === 1 && this.state.page1compiled === true) || (page === 2 && this.state.page2compiled === true))
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="flex";
          document.getElementsByClassName("carousel-control-next")[0].style.display="flex";
        }
        else if(page === 3)
        {
          document.getElementsByClassName("carousel-control-prev")[0].style.display="flex";
          document.getElementsByClassName("carousel-control-next")[0].style.display="none";
        }
    }
    return (
        <form>
        <Carousel activeIndex={page} onSelect={this.handleSelect} className="container-fluid p-auto w-75 border rounded border-2 margin-top" style={{height : "500px"}} autoPlay={false} interval={null} controls={true} indicators={false}>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                            <div className="m-5">
                              <label htmlFor="ricerca">Trova un ristorante:</label>
                              <input type="text" className="form-control mb-3" name="ricerca" id="ricerca" placeholder="Cerca" value={this.state.cerca} onChange={this.handleSearch}/>
                              {this.state.ristorantifiltrati.map((rs, index) => (
                              <div key={index}>
                                <input type="radio" className="mb-2 mr-1" id="seleziona_rist" name="seleziona_rist" value={index} onClick={this.handleRadioChange}/> <label htmlFor={rs.Ragione_sociale + "_seleziona"}>{rs.Ragione_sociale}</label>
                              </div>
                              ))}
                            </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                            <div>
                                <div className="m-5">
                                <label htmlFor="data_prenotazione">Seleziona il giorno:</label>
                                <input type="date" className="form-control" name="data_prenotazione" id="data_prenotazione" onChange={this.handleDateChange} />
                                </div>
                                <div className="m-5">
                                <label htmlFor="ora_arrivo">Seleziona l'ora di arrivo:</label>
                                <input type="time" className="form-control" name="ora_arrivo" id="ora_arrivo" onChange={this.handleTimeAChange}/>
                                </div>
                                <div  className="m-5">
                                <label htmlFor="ora_partenza">Seleziona l'ora di partenza:</label>
                                <input type="time" className="form-control" name="ora_partenza" id="ora_partenza" onChange={this.handleTimePChange}/>
                                </div>
                              </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
                            <div className="m-5">
                              <label htmlFor="num_persone">Seleziona il numero di persone:</label>
                              <input type="number" className="form-control" name="num_persone" id="num_persone" min="1" onChange={this.handleNumberChange} />
                            </div>
          </Carousel.Item>
          <Carousel.Item>
            <h1 className="my-4 d-flex justify-content-center">PRENOTAZIONE</h1>
            <table className="table table-striped">
               <thead className="thead-light">
                <tr>
                 <th>Codice</th>
                 <th>Numero posti</th>
                 <th>Giorno</th>
                 <th>Orario di occupazione</th>
                 <th></th>
                </tr>
               </thead>
               <tbody>
               {this.state.tavoli.map((rs, index) => (
                 <tr key={index}>
                   <td>{rs.Codice}</td>
                   <td>{rs.Num_posti}</td>
                   <td>{rs.Data_prenotazione}</td>
                   <td>{rs.Orario_arrivo} - {rs.Orario_partenza}</td>
                   <td>
                    <form className="form-group col-4">
                        <button type="submit" className="btn btn-outline-danger">Elimina</button>
                    </form>
                   </td>
                 </tr>
                 ))}
               </tbody>
             </table>
          </Carousel.Item>
          </Carousel>
        </form>
      );
    }
}
    
export default FormPrenotazione;