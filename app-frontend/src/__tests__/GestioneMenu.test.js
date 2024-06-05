import React from 'react';
import { act } from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import GestioneMenu from '../views/GestioneMenu';
import { ContextProvider } from '../contexts/ContextProvider';
import axiosClient from '../axios-client';

jest.mock('../axios-client');


const renderWithContext = (component) => {
    act(() => {
      return render(
        <ContextProvider>
            <MemoryRouter initialEntries={['/gestionemenu/1']}>
                <Routes>
                    <Route path="/gestionemenu/:ristoratoreId" element={component} />
                </Routes>
            </MemoryRouter>
        </ContextProvider>
      );
    });
};

describe('GestioneMenu', () => {
    it('renders the component with no plates', async () => {
        renderWithContext(<GestioneMenu/>);
        expect(screen.getByText('Non è presente nessuna pietanza.')).toBeInTheDocument();
    });

    it('renders the component with plates', async () => {
        const mockIngredienti = [
            { id: 1, nome: 'Pietanza 1' },
            { id: 2, nome: 'Pietanza 2' },
        ];

        axiosClient.get.mockResolvedValue({ data: mockIngredienti });

        renderWithContext(<GestioneMenu/>);

        await waitFor(() => {
            expect(screen.getByText('Pietanza 1')).toBeInTheDocument();
            expect(screen.getByText('Pietanza 2')).toBeInTheDocument();
        });
    });

    it('handles plate deletion', async () => {
        const mockIngredienti = [
            { id: 1, nome: 'Pietanza 1' },
            { id: 2, nome: 'Pietanza 2' },
        ];

        axiosClient.get.mockResolvedValue({ data: mockIngredienti });
        axiosClient.delete.mockResolvedValue({});

        window.confirm = jest.fn(() => true);

        renderWithContext(<GestioneMenu/>);

        await waitFor(() => {
            expect(screen.getByText('Pietanza 1')).toBeInTheDocument();
            expect(screen.getByText('Pietanza 2')).toBeInTheDocument();
        });

        act(() => {
            fireEvent.click(screen.getAllByText('Elimina')[0]);
        });

        await waitFor(() => {
            expect(screen.queryByText('Pietanza 1')).not.toBeInTheDocument();
        });
    });
});
