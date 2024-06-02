import React from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { ContextProvider } from '../contexts/ContextProvider';
import ModificaProfiloRistoratore from '../views/ModificaProfiloRistoratore';
import axiosClient from '../axios-client';

jest.mock('../axios-client');

const renderWithContext = (component) => {
    return render(
        <ContextProvider>
            {component}
        </ContextProvider>
    );
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
        renderWithContext(<ModificaProfiloRistoratore id={1}/>);

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
        renderWithContext(<ModificaProfiloRistoratore id={1}/>);

        await waitFor(() => {
            expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });

        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Due' }});
        expect(screen.getByLabelText('Nome').value).toBe('Ristorante Due');
    });

    it('handles form submission successfully', async () => {
        axiosClient.put.mockResolvedValueOnce({ data: {}});

        renderWithContext(<ModificaProfiloRistoratore id={1}/>);

        await waitFor(() => {
            expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });

        fireEvent.change(screen.getByLabelText('Nome'), { target: { value: 'Ristorante Modificato'}});
        fireEvent.click(screen.getByText('Modifica'));

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
        axiosClient.put.mockRejectedValueOnce({});
    
        renderWithContext(<ModificaProfiloRistoratore id={1}/>);
    
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
    
        renderWithContext(<ModificaProfiloRistoratore id={1}/>);
    
        await waitFor(() => {
          expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });
    
        fireEvent.click(screen.getByText('Elimina'));
    
        await waitFor(() => {
          expect(axiosClient.delete).toHaveBeenCalledWith('/elimina-ristoratore/1');
        });
      });

      it('handles delete action errors', async () => {
        axiosClient.delete.mockRejectedValueOnce({});
    
        renderWithContext(<ModificaProfiloRistoratore id={1}/>);
    
        await waitFor(() => {
          expect(screen.getByLabelText('Nome').value).toBe('Ristorante Uno');
        });
    
        fireEvent.click(screen.getByText('Elimina'));
    
        await waitFor(() => {
          expect(screen.getByText('Errore durante l\'eliminazione del ristoratore.')).toBeInTheDocument();
        });
      });
});