import React from 'react';
import { act } from 'react';
import { render, screen, fireEvent, waitFor } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import { MemoryRouter, Routes, Route } from 'react-router-dom';
import GestioneIngredienti from '../views/GestioneIngredienti';
import { ContextProvider } from '../contexts/ContextProvider';
import axiosClient from '../axios-client';

jest.mock('../axios-client');


const renderWithContext = (component) => {
    act(() => {
      return render(
        <ContextProvider>
            <MemoryRouter initialEntries={['/gestioneingredienti/1']}>
                <Routes>
                    <Route path="/gestioneingredienti/:ristoratoreId" element={component} />
                </Routes>
            </MemoryRouter>
        </ContextProvider>
      );
    });
};

describe('GestioneIngredienti', () => {
    it('renders the component with no ingredients', async () => {
        renderWithContext(<GestioneIngredienti/>);
        expect(screen.getByText('Non è presente nessun ingrediente.')).toBeInTheDocument();
    });

    it('renders the component with ingredients', async () => {
        const mockIngredienti = [
            { id: 1, nome: 'Ingrediente 1' },
            { id: 2, nome: 'Ingrediente 2' },
        ];

        axiosClient.get.mockResolvedValue({ data: mockIngredienti });

        renderWithContext(<GestioneIngredienti/>);

        await waitFor(() => {
            expect(screen.getByText('Ingrediente 1')).toBeInTheDocument();
            expect(screen.getByText('Ingrediente 2')).toBeInTheDocument();
        });
    });

    it('handles ingredient deletion', async () => {
        const mockIngredienti = [
            { id: 1, nome: 'Ingrediente 1' },
            { id: 2, nome: 'Ingrediente 2' },
        ];

        axiosClient.get.mockResolvedValue({ data: mockIngredienti });
        axiosClient.delete.mockResolvedValue({});

        window.confirm = jest.fn(() => true);

        renderWithContext(<GestioneIngredienti/>);

        await waitFor(() => {
            expect(screen.getByText('Ingrediente 1')).toBeInTheDocument();
            expect(screen.getByText('Ingrediente 2')).toBeInTheDocument();
        });

        act(() => {
            fireEvent.click(screen.getAllByText('Elimina')[0]);
        });

        await waitFor(() => {
            expect(screen.queryByText('Ingrediente 1')).not.toBeInTheDocument();
        });
    });
});
