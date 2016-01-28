pessoas
    .factory('PessoasSrv', function($resource) {
       return $resource(
           '/index.php/pessoas/:id', {
               id: '@id'
           },
           {
               update: {
                   method: 'PUT',
                   url: '/index.php/pessoas/:id/'
               }
           }
       );
    });