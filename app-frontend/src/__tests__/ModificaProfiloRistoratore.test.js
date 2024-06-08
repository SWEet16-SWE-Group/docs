import React from 'react';
import { act } from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import { ContextProvider } from '../contexts/ContextProvider';
import ModificaProfiloRistoratore from '../views/ModificaProfiloRistoratore';
import axiosClient from '../axios-client';

jest.mock('../axios-client');

const renderWithContext = (component) => {
    act(() => {
      return render(
        <ContextProvider>
            <MemoryRouter initialEntries={['/modifica-ristoratore/1']}>
                <Routes>
                    <Route path="/modifica-ristoratore/:id" element={component} />
                </Routes>
            </MemoryRouter>
        </ContextProvider>
      );
    });
};

describe('ModificaProfiloRistoratore', () => {
    beforeEach(() => {
        axiosClient.get.mockResolvedValueOnce({
            data: {
                nome: 'Ristorante Uno',
                indirizzo: 'Indirizzo Uno',
                telefono: '1234567890',
                capienza: '50',
                orario: '19:30 - 20:30'
            }
        });
    });

    it('renders the form correctly', async () => {
        renderWithContext(<ModificaProfiloRistoratore />);

        await waitFor(() => {
            expect(screen.getByText('Modifica le informazioni relative a questo profilo')).toBeInTheDocument();
            expect(screen.getByLabelText('Nome')).toBeInTheDocument();
            expect(screen.getByLabelText('Indirizzo')).toBeInTheDocument();
            expect(screen.getByLabelText('Telefono')).toBeInTheDocument();
            expect(screen.getByLabelText('Capienza')).toBeInTheDocument();
            expect(screen.getByLabelText('Orario')).toBeInTheDocument();
        });
    });

    it('handles form input changes', async () => {
        renderWithContext(<ModificaProfiloRistoratore />);

        await waitFor(() => {
            expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });
        act(() => {
          fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Due' } });
        });

        expect(screen.getByLabelText('Nome').value).toBe('Ristorante Due');
    });

    it('handles form submission successfully', async () => {
        axiosClient.put.mockResolvedValueOnce({ data: { status: 'success', notification: 'Dati aggiornati con successo.' } });

        renderWithContext(<ModificaProfiloRistoratore />);

        await waitFor(() => {
            expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });
        act(() => {
          fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Modificato' } });
          fireEvent.click(screen.getByText('Conferma modifiche'));
        });

        await waitFor(() => {
            expect(axiosClient.put).toHaveBeenCalledWith('/modifica-ristoratore/1', {
                user: localStorage.getItem('USER_ID'),
                nome: 'Ristorante Modificato',
                indirizzo: 'Indirizzo Uno',
                telefono: '1234567890',
                capienza: '50',
                orario: '19:30 - 20:30'
            });
        });
    });

    it('handles form submission errors', async () => {
        axiosClient.put.mockRejectedValueOnce({ response: { data: { errors: { nome : ['Nome è richiesto.'] } } } });

        renderWithContext(<ModificaProfiloRistoratore />);

        await waitFor(() => {
            expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });

        act(() => {
          fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Modificato' } });
          fireEvent.click(screen.getByText('Conferma modifiche'));
        });

        await waitFor(() => {
            expect(screen.getByText('Errore durante l\'aggiornamento dei dati.')).toBeInTheDocument();
        });
    });
});
