import { Route, Routes } from 'react-router-dom';
import Login from './components/login';
import DashboardClienti from './components/dashboard_clienti.js';
import DashboardRistoratori from './components/dashboard_ristoratori.js';
import FormPrenotazione from './components/form_prenotazione.js';
import './App.css';

function App() {
    return (
    <div className="App">
        <Routes>
          <Route path="/" element={<Login />} />
          <Route path="/login" element={<Login />} />
          <Route path="/dashboardclienti" element={<DashboardClienti />} />
          <Route path="/dashboardristoratori" element={<DashboardRistoratori />} />
          <Route path="/form_prenotazione" element={<FormPrenotazione />} />
        </Routes>
    </div>
  );
}

export default App;

