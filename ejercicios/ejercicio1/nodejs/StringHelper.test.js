const StringHelper = require('./StringHelper');

describe('Pruebas de StringHelper en Node.js', () => {

  describe('Método truncate', () => {
    it('debe truncar el texto y agregar el sufijo si supera el maxLength', () => {
      const resultado = StringHelper.truncate('Despliegue de Arachiz', 10);
      expect(resultado).toBe('Despliegue...');
    });

    it('debe devolver el texto original si la longitud es exactamente igual al maxLength', () => {
      const resultado = StringHelper.truncate('ADSO', 4);
      expect(resultado).toBe('ADSO');
    });

    it('debe lanzar una excepción si maxLength es 0 o negativo', () => {
      expect(() => StringHelper.truncate('Texto', 0)).toThrow('El maxLength debe ser mayor a 0');
    });
  });

  describe('Método toSlug', () => {
    it('debe convertir texto con caracteres especiales a slug minúscula', () => {
      const resultado = StringHelper.toSlug('¡Arachiz Backend! 2026');
      expect(resultado).toBe('arachiz-backend-2026');
    });

    it('debe manejar múltiples espacios correctamente', () => {
      const resultado = StringHelper.toSlug('  Fondo   azul   y amarillo   ');
      expect(resultado).toBe('fondo-azul-y-amarillo');
    });
  });

  describe('Método countWords', () => {
    it('debe contar palabras separadas por múltiples espacios', () => {
      const resultado = StringHelper.countWords('  Servidor   Express  en   memoria ');
      expect(resultado).toBe(4);
    });

    it('debe devolver 0 si el texto está vacío o solo tiene espacios', () => {
      const resultado = StringHelper.countWords('       ');
      expect(resultado).toBe(0);
    });
  });
});