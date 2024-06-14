import React from "react";
import { render, screen } from '@testing-library/react';
import '@testing-library/jest-dom/extend-expect';
import NotFound from "../views/NotFound";


describe('NotFound', () => {

    it('should render the component', () => {
        render(<NotFound/>);
        expect(screen.getByText('404 - Page Not Found')).toBeInTheDocument();
    });

});