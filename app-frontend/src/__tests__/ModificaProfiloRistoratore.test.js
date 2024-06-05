import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Route, Routes } from 'react-router-dom';
import { ContextProvider } from '../contexts/ContextProvider';
import ModificaProfiloRistoratore from '../views/ModificaProfiloRistoratore';
import axiosClient from '../axios-client';

jest.mock('../axios-client');

const renderWithContext = (component) => {
    return render(
        <ContextProvider>
            <MemoryRouter initialEntries={['/modifica-ristoratore/1']}>
              <Routes>
                <Route path="/modifica-ristoratore/:id" element={component}>
                </Route>
              </Routes>
            </MemoryRouter>
        </ContextProvider>
    );
};

beforeEach(() => {
    jest.clearAllMocks();
    localStorage.setItem('USER_ID', '1');
});

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
            expect(screen.getByText('Modifica account ristoratore')).toBeInTheDocument();
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

        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Due' }});
        expect(screen.getByLabelText('Nome').value).toBe('Ristorante Due');
    });

    it('handles form submission successfully', async () => {
        axiosClient.put.mockResolvedValueOnce({ data: {}});

        renderWithContext(<ModificaProfiloRistoratore />);

        await waitFor(() => {
            expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });

        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Modificato'}});
        fireEvent.click(screen.getByText('Modifica'));

        await waitFor(() => {
            expect(axiosClient.put).toHaveBeenCalledWith('/modifica-ristoratore/1', {
                user: '1',
                nome: 'Ristorante Modificato',
                indirizzo: 'Indirizzo Uno',
                telefono: '1234567890',
                capienza: '50',
                orario: '19:30 - 20:30'
            });
        });
    });

    it('handles form submission errors', async () => {
        axiosClient.put.mockRejectedValueOnce(new Error('Update failed'));

        renderWithContext(<ModificaProfiloRistoratore />);

        await waitFor(() => {
            expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });

        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Modificato' } });
        fireEvent.click(screen.getByText('Modifica'));

        await waitFor(() => {
            expect(screen.getByText('Errore durante l\'aggiornamento dei dati.')).toBeInTheDocument();
        });
    });

    it('handles delete action successfully', async () => {
        axiosClient.delete.mockResolvedValueOnce({});

        renderWithContext(<ModificaProfiloRistoratore />);

        await waitFor(() => {
            expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });

        fireEvent.click(screen.getByText('Elimina'));

        await waitFor(() => {
            expect(axiosClient.delete).toHaveBeenCalledWith('/elimina-ristoratore/1');
        });
    });

    it('handles delete action errors', async () => {
        axiosClient.delete.mockRejectedValueOnce(new Error('Delete failed'));

        renderWithContext(<ModificaProfiloRistoratore />);

        await waitFor(() => {
            expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });

        fireEvent.click(screen.getByText('Elimina'));

        await waitFor(() => {
            expect(screen.getByText('Errore durante l\'eliminazione del ristoratore.')).toBeInTheDocument();
        });
    });
});