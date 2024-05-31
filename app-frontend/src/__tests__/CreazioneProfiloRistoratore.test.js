import React from 'react';
import { render, screen, fireEvent, waitFor, act } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { ContextProvider } from '../contexts/ContextProvider.jsx';
import CreazioneProfiloRistoratore from '../views/CreazioneProfiloRistoratore.jsx';
import axiosClient from '../axios-client.js';

jest.mock('../axios-client');

const renderWithContext = (component) => {
    return render(
        <ContextProvider>
            {component}
        </ContextProvider>
    );
};

describe('CreazioneProfiloRistoratore', () => {
    it('renders the form correctly', () => {
        renderWithContext(<CreazioneProfiloRistoratore/>);
        expect(screen.getByText('Crea account ristoratore')).toBeInTheDocument();
        expect(screen.getByLabelText('Nome')).toBeInTheDocument();
        expect(screen.getByLabelText('Indirizzo')).toBeInTheDocument();
        expect(screen.getByLabelText('Telefono')).toBeInTheDocument();
        expect(screen.getByLabelText('Capienza')).toBeInTheDocument();
        expect(screen.getByLabelText('Orario apertura - chiusura')).toBeInTheDocument();
    });

    it('submits the form successfuly', async () => {
        axiosClient.post.mockResolvedValueOnce({ data: {} });

        renderWithContext(<CreazioneProfiloRistoratore/>);

        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Test Ristorante' }});
        fireEvent.change(screen.getByLabelText('Indirizzo'), { target: { value: 'Test Indirizzo' }});
        fireEvent.change(screen.getByLabelText('Telefono'), { target: { value: '1234567890' }});
        fireEvent.change(screen.getByLabelText('Capienza'), { target: { value: '50' }});
        fireEvent.change(screen.getByLabelText('Orario apertura - chiusura'), { target: { value: '19:30 - 20:30' }});

        fireEvent.click(screen.getByText('Conferma'));

        expect(axiosClient.post).toHaveBeenCalledWith('/crea-ristoratore', {
            user: localStorage.getItem('USER_ID'),
            nome: 'Test Ristorante',
            indirizzo: 'Test Indirizzo',
            telefono: '1234567890',
            capienza: "50",
            orario: '19:30 - 20:30',
        });
    });

    it('handles form submission errors', async () => {
        axiosClient.post.mockRejectedValueOnce({
            response: {
                data: {
                    errors: {
                        nome: ['Nome è richiesto'],
                    }
                }
            }
        });

        renderWithContext(<CreazioneProfiloRistoratore/>);

        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Test Ristorante' }});
        fireEvent.change(screen.getByLabelText('Indirizzo'), { target: { value: 'Test Indirizzo' }});
        fireEvent.change(screen.getByLabelText('Telefono'), { target: { value: '1234567890' }});
        fireEvent.change(screen.getByLabelText('Capienza'), { target: { value: '50' }});
        fireEvent.change(screen.getByLabelText('Orario apertura - chiusura'), { target: { value: '19:30 - 20:30' }});
        
        fireEvent.click(screen.getByText('Conferma'));

        await waitFor(() => {
            expect(screen.getByTestId('notifica').textContent).toBe('Nome è richiesto');
            expect(screen.getByText('Nome è richiesto')).toBeInTheDocument();
        });
    });

    it('resets the form on cancel', () => {
        renderWithContext(<CreazioneProfiloRistoratore />);
      
        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Test Ristorante' } });
        fireEvent.change(screen.getByLabelText('Indirizzo'), { target: { value: 'Test Indirizzo' } });
        fireEvent.change(screen.getByLabelText('Telefono'), { target: { value: '1234567890' } });
        fireEvent.change(screen.getByLabelText('Capienza'), { target: { value: '50' } });
        fireEvent.change(screen.getByLabelText('Orario apertura - chiusura'), { target: { value: '19:30 - 20:30' } });
      
        fireEvent.click(screen.getByText('Annulla'));
      
        expect(screen.getByLabelText('Nome').value).toBe('');
        expect(screen.getByLabelText('Indirizzo').value).toBe('');
        expect(screen.getByLabelText('Telefono').value).toBe('');
        expect(screen.getByLabelText('Capienza').value).toBe('');
        expect(screen.getByLabelText('Orario apertura - chiusura').value).toBe('');
      });      
});