import { Route, Routes } from 'react-router-dom';
import Login from './components/login';
import DashboardClienti from './components/dashboard_clienti';
import DashboardRistoratori from './components/dashboard_ristoratori';
import FormPrenotazione from './components/form_prenotazione.js';
import MenuPietanze from './components/menu_pietanze.js';
import DettagliPietanza from './components/dettagli_pietanza.js';
import './App.css';


function App() {
    return (
    <div className="App">
        <Routes>
          <Route path="/" element={<Login />} />
          <Route path="/login" element={<Login />} />
          <Route path="/dashboardclienti" element={<DashboardClienti />} />
          <Route path="/dashboardristoratori" element={<DashboardRistoratori />} />
          <Route path="/formprenotazione" element={<FormPrenotazione />} />
          <Route path="/ordinazione" element={<MenuPietanze />} />
          <Route path="/dettagli/:id" element={<DettagliPietanza />} />
        </Routes>
    </div>
  );
}

export default App;

