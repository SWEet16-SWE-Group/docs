import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider } from '../contexts/ContextProvider';
import CreazioneProfiloRistoratore from '../views/CreazioneProfiloRistoratore';
import axiosClient from '../axios-client';
import { act } from 'react';

jest.mock('../axios-client');

const renderWithContext = (component) => {
    act(() => {
        return render(
            <ContextProvider>
                <MemoryRouter initialEntries={['/crea-ristoratore']}>
                    <Routes>
                        <Route path="/crea-ristoratore" element={component} />
                    </Routes>
                </MemoryRouter>
            </ContextProvider>
        );
    });
};

describe('CreazioneProfiloRistoratore', () => {
    it('renders the form correctly', () => {
        renderWithContext(<CreazioneProfiloRistoratore />);

        expect(screen.getByText('Crea account ristoratore')).toBeInTheDocument();
        expect(screen.getByLabelText('Nome')).toBeInTheDocument();
        expect(screen.getByLabelText('Indirizzo')).toBeInTheDocument();
        expect(screen.getByLabelText('Telefono')).toBeInTheDocument();
        expect(screen.getByLabelText('Capienza')).toBeInTheDocument();
        expect(screen.getByLabelText('Orario apertura - chiusura')).toBeInTheDocument();
    });

    it('handles form input changes', () => {
        renderWithContext(<CreazioneProfiloRistoratore />);

        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Uno' } });
        expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
    });

    it('handles form submission successfully', async () => {
        axiosClient.post.mockResolvedValueOnce({ data: { status: 'success', notification: 'Ristorante creato con successo.' } });

        renderWithContext(<CreazioneProfiloRistoratore />);
        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Uno' } });
        fireEvent.change(screen.getByLabelText('Indirizzo'), { target: { value: 'Indirizzo Uno' } });
        fireEvent.change(screen.getByLabelText('Telefono'), { target: { value: '1234567890' } });
        fireEvent.change(screen.getByLabelText('Capienza'), { target: { value: '50' } });
        fireEvent.change(screen.getByLabelText('Orario apertura - chiusura'), { target: { value: '19:30 - 20:30' } });

        fireEvent.click(screen.getByText('Conferma'));

        await waitFor(() => {
            expect(axiosClient.post).toHaveBeenCalledWith('/crea-ristoratore', {
                user: localStorage.getItem('USER_ID'),
                nome: 'Ristorante Uno',
                cucina: '',
                indirizzo: 'Indirizzo Uno',
                telefono: '1234567890',
                capienza: '50',
                orario: '19:30 - 20:30'
            });
        });
    });

    it('handles form submission errors', async () => {
        axiosClient.post.mockRejectedValueOnce({
            response: {
                data: {
                    errors: {
                        nome: ['Nome è richiesto.'],
                        indirizzo: ['Indirizzo è richiesto.']
                    }
                }
            }
        });

        renderWithContext(<CreazioneProfiloRistoratore />);

        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: '' } });
        fireEvent.change(screen.getByLabelText('Indirizzo'), { target: { value: '' } });
        fireEvent.change(screen.getByLabelText('Telefono'), { target: { value: '1234567890' } });
        fireEvent.change(screen.getByLabelText('Capienza'), { target: { value: '50' } });
        fireEvent.change(screen.getByLabelText('Orario apertura - chiusura'), { target: { value: '19:30 - 20:30' } });

        fireEvent.click(screen.getByText('Conferma'));

        await waitFor(() => {
            expect(screen.getByText('Nome è richiesto.')).toBeInTheDocument();
            expect(screen.getByText('Indirizzo è richiesto.')).toBeInTheDocument();
        });
    });
});
