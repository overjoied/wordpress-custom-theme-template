function importAllSVGs() {
  require.context('/', false, /.svg$/);
}

importAllSVGs();